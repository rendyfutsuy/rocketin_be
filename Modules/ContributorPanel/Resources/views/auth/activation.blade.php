@extends('contributorPanel::layouts.app')

@section('content')
<div class="container mt-4">
    <activation-form
        encoded-email="{{ $encodedEmail}}"
        hide-email="{{ $hiddenEmail }}"
        :timer="60"
    ></activation-form>
</div>
@endsection

@section("script")
@parent
<script>
</script>
@endsection
