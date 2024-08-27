@extends('errors::layouts.app')

@section('title', __('Payment Required'))
@section('code', '402')
@section('message', __($exception->getMessage() ?? 'Payment Required'))
@section('lightImage', asset('assets/images/errors/car-dealer.png'))
@section('darkImage', asset('assets/images/errors/car-dealer-dark.png'))
