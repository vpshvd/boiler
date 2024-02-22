<?php

namespace App\Client;

interface BoredomApiClientInterface
{
    public function getActivity(int $participants): string;
}