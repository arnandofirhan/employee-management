@extends('errors::layouts.app')

@section('title', __('Too Many Requests'))
@section('code', '429')
@section('message', __($exception->getMessage() ?? 'Too Many Requests'))
@section('lightImage', asset('assets/images/errors/time.png'))
@section('darkImage', asset('assets/images/errors/time-dark.png'))
