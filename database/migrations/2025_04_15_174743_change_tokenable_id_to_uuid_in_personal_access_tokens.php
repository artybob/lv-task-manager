<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTokenableIdToUuidInPersonalAccessTokens extends Migration
{
    public function up()
    {
        // Проверяем существование foreign key перед удалением
        $sm = Schema::getConnection()->getDoctrineSchemaManager();
        $foreignKeys = $sm->listTableForeignKeys('personal_access_tokens');

        $fkExists = collect($foreignKeys)->contains(function ($fk) {
            return $fk->getName() === 'personal_access_tokens_tokenable_id_foreign';
        });

        if ($fkExists) {
            Schema::table('personal_access_tokens', function (Blueprint $table) {
                $table->dropForeign(['tokenable_id']);
            });
        }

        // Изменяем тип столбца
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->uuid('tokenable_id')->change();
        });
    }

    public function down()
    {
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->unsignedBigInteger('tokenable_id')->change();
        });
    }
}
