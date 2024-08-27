@extends('errors::layouts.app')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden'))
@section('lightImage', asset('assets/images/errors/closed.png'))
@section('darkImage', asset('assets/images/errors/closed-dark.png'))
