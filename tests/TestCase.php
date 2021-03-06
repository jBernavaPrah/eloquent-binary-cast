<?php


namespace JBernavaPrah\EloquentBinaryCast\Tests;


use Illuminate\Database\Capsule\Manager;

class TestCase  extends \PHPUnit\Framework\TestCase
{
    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $db = new Manager();
        $db->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        $db->addConnection([
            'driver' => 'pgsql',
            'database' => ':memory:',
            'prefix' => '',
        ], 'pgsql');
        $db->setAsGlobal();
        $db->bootEloquent();



    }
}