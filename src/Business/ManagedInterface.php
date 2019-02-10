<?php

namespace App\Business;


Interface ManagedInterface
{
    public function save($data);
    public function getAll();
    public function deleteRecord($id);
    public function show($id);
    public function find($id);
    public function findBy($filter);
}