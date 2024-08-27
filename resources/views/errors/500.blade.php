@extends('errors::layouts.app')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __($exception->getMessage() ?? 'Server Error'))
@section('lightImage', asset('assets/images/errors/startap.png'))
@section('darkImage', asset('assets/images/errors/startap-dark.png'))
