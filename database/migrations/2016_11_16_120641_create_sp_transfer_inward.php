<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpTransferInward extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = <<<SQL
CREATE PROCEDURE sp_transfer_inward(
    IN app_id INT(10),
    IN member_id INT(10),
    IN tx_amount DECIMAL(18,2),
    IN tx_no VARCHAR(32),
    IN tx_at TIMESTAMP,
    OUT sp_code TINYINT(3) UNSIGNED,
    OUT balance DECIMAL(18,2)
)
proc_label:BEGIN
    DECLARE _coin DECIMAL(18,2);

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;

    START TRANSACTION;
        # 交易金額小於 0 就離開交易
        IF tx_amount < 0 THEN
            SET sp_code = 1;
            ROLLBACK;
            LEAVE proc_label;
        END IF;

        SELECT coin
        INTO _coin
        FROM members
        WHERE id = member_id AND app_id = app_id
        FOR UPDATE;

        # 查無此會員就離開交易
        IF _coin IS NULL THEN
            SET sp_code = 2;
            ROLLBACK;
            LEAVE proc_label;
        END IF;

        SET balance = _coin + tx_amount;

        UPDATE members
        SET coin = balance
        WHERE id = member_id;

        # 交易紀錄
        INSERT INTO transfers (app_id, member_id, amount, balance, type, transaction_no, transaction_at)
        VALUES (app_id, member_id, tx_amount, balance, 0, tx_no, tx_at);

        SET sp_code = 0;
    COMMIT;
END
SQL;

        DB::unprepared($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_transfer_inward');
    }
}
