<?php
namespace App\Helpers;

/**
 * Validator — stateless input validation.
 *
 * Usage:
 *   $v = new Validator($data);
 *   $v->required('email')->email('email')->minLength('password', 8);
 *   if ($v->fails()) { return $v->errors(); }
 */
class Validator
{
    private array $data;
    private array $errors = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function required(string $field, string $label = ''): self
    {
        $label = $label ?: ucfirst(str_replace('_', ' ', $field));
        if (!isset($this->data[$field]) || trim((string)$this->data[$field]) === '') {
            $this->errors[$field] = "{$label} is required";
        }
        return $this;
    }

    public function email(string $field): self
    {
        $value = $this->data[$field] ?? '';
        if ($value && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = 'Invalid email format';
        }
        return $this;
    }

    public function minLength(string $field, int $min, string $label = ''): self
    {
        $label = $label ?: ucfirst(str_replace('_', ' ', $field));
        $value = $this->data[$field] ?? '';
        if ($value && strlen($value) < $min) {
            $this->errors[$field] = "{$label} must be at least {$min} characters";
        }
        return $this;
    }

    public function numeric(string $field, string $label = ''): self
    {
        $label = $label ?: ucfirst(str_replace('_', ' ', $field));
        $value = $this->data[$field] ?? '';
        if ($value !== '' && !is_numeric($value)) {
            $this->errors[$field] = "{$label} must be a number";
        }
        return $this;
    }

    public function phone(string $field): self
    {
        $value = $this->data[$field] ?? '';
        if ($value && !preg_match('/^\d{10,15}$/', $value)) {
            $this->errors[$field] = 'Phone must be 10-15 digits';
        }
        return $this;
    }

    public function min(string $field, float $min, string $label = ''): self
    {
        $label = $label ?: ucfirst(str_replace('_', ' ', $field));
        $value = $this->data[$field] ?? 0;
        if (is_numeric($value) && (float)$value < $min) {
            $this->errors[$field] = "{$label} must be at least {$min}";
        }
        return $this;
    }

    public function dateInFuture(string $field, string $label = ''): self
    {
        $label = $label ?: ucfirst(str_replace('_', ' ', $field));
        $value = $this->data[$field] ?? '';
        if ($value && strtotime($value) <= time()) {
            $this->errors[$field] = "{$label} must be in the future";
        }
        return $this;
    }

    public function fails(): bool
    {
        return !empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function firstError(): string
    {
        return reset($this->errors) ?: '';
    }
}
