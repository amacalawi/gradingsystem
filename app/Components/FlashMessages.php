<?php

namespace App\Components;

trait FlashMessages
{
    protected static function message($id, $module, $type, $icon, $info, $message)
    {
        if (session()->has('messages')) {
            $messages = session()->pull('messages');
        }

        $messages[] = $message = ['id' => $id, 'module' => $module, 'type' => $type, 'icon' => $icon, 'info' => $info, 'message' => $message];

        session()->flash('messages', $messages);

        return $message;
    }

    protected static function messages()
    {
        return self::hasMessages() ? session()->pull('messages') : [];
    }

    protected static function hasMessages()
    {
        return session()->has('messages');
    }

    protected static function success($message)
    {
        return self::message('success', $message);
    }

    protected static function info($message)
    {
        return self::message('info', $message);
    }

    protected static function warning($message)
    {
        return self::message('warning', $message);
    }

    protected static function danger($message)
    {
        return self::message('danger', $message);
    }
}