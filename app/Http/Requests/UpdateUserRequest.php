<?php

namespace App\Http\Requests;

use App\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('school-setup') && Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'name'    => [
                'required'],
            'email'   => [
                'required',
                'unique:users,email,' . request()->route('user')->id],
            'rfidcard' => [
                request()->rfidcard ? 'unique:users,rfidcard,' . request()->route('user')->id : null],
            'roles.*' => [
                'integer'],
            'roles'   => [
                'required',
                'array'],
        ];
    }
}
