<?php

function validation($values, $rules, $labels = [])
{
    $errors = [];

    foreach ($rules as $fieldName => $fieldRules) {
        // تنظيف أولي
        $raw   = $values[$fieldName] ?? null;
        $value = is_string($raw) ? trim($raw) : $raw;

        // اسم العرض (تعريب)
        $label = $labels[$fieldName] ?? $fieldName;

        foreach ($fieldRules as $rule) {
            if ($rule === 'require') {
                if ($value === null || $value === '') {
                    $errors[$fieldName][] = "$label مطلوب.";
                }
            } elseif (strpos($rule, 'max:') === 0) {
                $max = (int) explode(':', $rule)[1];
                if (mb_strlen((string)$value, 'UTF-8') > $max) {
                    $errors[$fieldName][] = "$label يجب ألا يزيد عن $max حروف.";
                }
            } elseif (strpos($rule, 'min:') === 0) {
                $min = (int) explode(':', $rule)[1];
                if (mb_strlen((string)$value, 'UTF-8') < $min) {
                    $errors[$fieldName][] = "$label يجب ألا يقل عن $min حروف.";
                }
            } elseif ($rule === 'phone') {
                if (!preg_match('/^01[0-9]{9}$/', (string)$value)) {
                    $errors[$fieldName][] = "$label يجب أن يكون رقم موبايل مصري صحيح.";
                }
            } elseif ($rule === 'email') {
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[$fieldName][] = "$label يجب أن يكون بريدًا إلكترونيًا صحيحًا.";
                }
            } elseif ($rule === 'password') {
                if (mb_strlen((string)$value, 'UTF-8') < 6) {
                    $errors[$fieldName][] = "خطأ في $label";
                }
            } elseif ($rule === 'int') {
                if (!filter_var($value, FILTER_VALIDATE_INT) && $value !== 0 && $value !== '0') {
                    $errors[$fieldName][] = "$label يجب أن يكون رقمًا صحيحًا.";
                }
            }
        }
    }

    return $errors;
}