<?php

namespace Hageman\NetSuite;

use JsonSerializable;

final class Response implements JsonSerializable
{
    /**
     * @var int
     */
    public $code;

    /**
     * @var string
     */
    public $message;

    /**
     * @var bool
     */
    public $success;

    /**
     * @var mixed|array
     */
    public $data;

    /**
     * Create a new response.
     */
    public function __construct($code, $message, $success, $data)
    {
        if (!is_array($data)) $data = (array)$data;

        $this->code = $code;
        $this->message = $message;
        $this->success = $success;
        $this->data = $data;
    }

    /**
     * Return the response as a string.
     *
     * @return string
     */
    public function __toString(): string
    {
        $status = $this->success ? 'success' : 'fail';
        return "$status: ($this->code) $this->message" . ($this->count() ? " [data:{$this->count()}]" : '');
    }

    /**
     * Return to data count of the response.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->data);
    }

    /**
     * Return an array with some attributes of the response.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'code' => $this->code,
            'message' => $this->message,
            'success' => $this->success,
            'data' => $this->data,
        ];
    }
}
