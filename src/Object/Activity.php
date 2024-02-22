<?php

namespace App\Object;
use Symfony\Component\Validator\Constraints as Assert;
class Activity
{

    #[Assert\NotBlank]
    private string $activity;

    #[Assert\NotBlank]
    private string $type;


    public function getActivity(): string
    {
        return $this->activity;
    }

    public function setActivity(string $activity): Activity
    {
        $this->activity = $activity;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): Activity
    {
        $this->type = $type;
        return $this;
    }


}