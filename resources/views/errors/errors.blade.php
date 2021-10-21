<?php
/**
 * Created by PhpStorm.
 * User: Blue Dragon
 * Date: 2020.04.24
 * Time: PM 4:55
 */
?>
@if(count($errors) > 0)
    @foreach ($errors->all() as $error)
        {{ $error }}
    @endforeach
@endif
