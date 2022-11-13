<?php

namespace Database;

interface DatabaseInterface
{

    public function insert(string $name_table, array $column);
}