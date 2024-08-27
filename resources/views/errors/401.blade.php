@extends('errors::layouts.app')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message', __($exception->getMessage() ?? 'Unauthorized'))
@section('lightImage', asset('assets/images/errors/there-is-nothing-here.png'))
@section('darkImage', asset('assets/images/errors/there-is-nothing-here-dark.png'))
