@extends('errors::layouts.app')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __($exception->getMessage() ?? 'Not Found'))
@section('lightImage', asset('assets/images/errors/404.png'))
@section('darkImage', asset('assets/images/errors/404-dark.png'))
