<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    /**
     * The connection name for the model.
     *
     * @var string|null
     */
    protected $connection = 'landlord';

    protected $guarded = [];

    /**
     *
     */
    public function use()
    {
        config([
            'database.connections.mysql.database' => $this->database,
        ]);

        DB::purge('mysql');

        DB::reconnect('mysql');

        Schema::connection('mysql')->getConnection()->reconnect();

        app()->instance('tenant', $this);

        return $this;
    }
}
