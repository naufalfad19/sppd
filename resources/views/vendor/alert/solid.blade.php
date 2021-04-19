<!--
<div class="alert alert-solid-brand alert-bold" role="alert">
  <div class="alert-text">A simple primary alert—check it out!</div>
</div>
<div class="alert alert-solid-success alert-bold" role="alert">
  <div class="alert-text">A simple success alert—check it out!</div>
</div>
<div class="alert alert-solid-danger alert-bold" role="alert">
  <div class="alert-text">A simple danger alert—check it out!</div>
</div>
<div class="alert alert-solid-warning alert-bold" role="alert">
  <div class="alert-text">A simple warning alert—check it out!</div>
</div>
<div class="alert alert-elevate alert-light alert-bold" role="alert">
  <div class="alert-text">A simple light alert—check it out!</div>
</div>
<div class="alert alert-solid-dark alert-bold" role="alert">
  <div class="alert-text">A simple dark alert—check it out!</div>
</div>
-->

@if (count($errors) > 0)
  @foreach ($errors->all() as $error)
      <div class="alert alert-solid-danger alert-bold" role="alert">
        <div class="alert-text">{{ $error }}</div>
        <div class="alert-close">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="la la-close"></i></span>
          </button>
        </div>
      </div>
  @endforeach
@endif
