@extends('errors::layouts.app')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message', __($exception->getMessage() ?? 'Service Unavailable'))
@section('lightImage', asset('assets/images/errors/temporarily-not-available.png'))
@section('darkImage', asset('assets/images/errors/temporarily-not-available-dark.png'))
