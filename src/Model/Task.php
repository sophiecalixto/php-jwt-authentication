<?php

namespace SophieCalixto\JWTAuthAPI\Model;

class Task
{
    private int $id;
    private string $title;
    private string $description;
    private int $user_id;
    private bool $completed;

    public function __construct(int $id, string $title, string $description, int $user_id, bool $completed)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->user_id = $user_id;
        $this->completed = $completed;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }
}