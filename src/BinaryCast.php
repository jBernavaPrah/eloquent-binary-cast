<?php


namespace JBernavaPrah\EloquentBinaryCast;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\PostgresConnection;

class BinaryCast implements CastsAttributes
{
   protected function getPostgresCast($value)
    {
        if (is_resource($value)) {
            rewind($value);
            $value = stream_get_contents($value);
        }

        return hex2bin($value);
    }

    protected function setPostgresCast($value)
    {
        return bin2hex($value);
    }

    /**
     * @inheritDoc
     */
    public function get($model, $key, $value, array $attributes)
    {

        if ($model->getConnection() instanceof PostgresConnection) {
            return $this->getPostgresCast($value);
        }

        return $value;
    }

    /**
     * @inheritDoc
     */
    public function set($model,  $key, $value, array $attributes)
    {
        if ($model->getConnection() instanceof PostgresConnection) {
            return $this->setPostgresCast($value);
        }

        return $value;
    }
}