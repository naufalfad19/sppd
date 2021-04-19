<!--
  <div class="alert alert-primary fade show" role="alert">
    <div class="alert-icon"><i class="flaticon-warning"></i></div>
    <div class="alert-text">A simple primary alert—check it out!</div>
    <div class="alert-close">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true"><i class="la la-close"></i></span>
      </button>
    </div>
  </div>
  <div class="alert alert-secondary  fade show" role="alert">
    <div class="alert-icon"><i class="flaticon-questions-circular-button"></i></div>
    <div class="alert-text">A simple secondary alert—check it out!</div>
    <div class="alert-close">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true"><i class="la la-close"></i></span>
      </button>
    </div>
  </div>
  <div class="alert alert-success fade show" role="alert">
    <div class="alert-icon"><i class="flaticon-warning"></i></div>
    <div class="alert-text">A simple success alert—check it out!</div>
    <div class="alert-close">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true"><i class="la la-close"></i></span>
      </button>
    </div>
  </div>
  <div class="alert alert-danger fade show" role="alert">
    <div class="alert-icon"><i class="flaticon-questions-circular-button"></i></div>
    <div class="alert-text">A simple danger alert—check it out!</div>
    <div class="alert-close">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true"><i class="la la-close"></i></span>
      </button>
    </div>
  </div>
  <div class="alert alert-warning fade show" role="alert">
    <div class="alert-icon"><i class="flaticon-warning"></i></div>
    <div class="alert-text">A simple warning alert—check it out!</div>
    <div class="alert-close">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true"><i class="la la-close"></i></span>
      </button>
    </div>
  </div>
  <div class="alert alert-info fade show" role="alert">
    <div class="alert-icon"><i class="flaticon-questions-circular-button"></i></div>
    <div class="alert-text">A simple info alert—check it out!</div>
    <div class="alert-close">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true"><i class="la la-close"></i></span>
      </button>
    </div>
  </div>
  <div class="alert alert-light alert-elevate fade show" role="alert">
    <div class="alert-icon"><i class="flaticon-warning"></i></div>
    <div class="alert-text">A simple light alert—check it out!</div>
    <div class="alert-close">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true"><i class="la la-close"></i></span>
      </button>
    </div>
  </div>
  <div class="alert alert-dark fade show" role="alert">
    <div class="alert-icon"><i class="flaticon-questions-circular-button"></i></div>
    <div class="alert-text">A simple dark alert—check it out!</div>
    <div class="alert-close">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true"><i class="la la-close"></i></span>
      </button>
    </div>

  </div>
-->

@if (count($errors) > 0)
  @foreach ($errors->all() as $error)
  <div class="alert alert-danger fade show" role="alert">
    <div class="alert-text">{{$error}}</div>
    <div class="alert-close">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true"><i class="la la-close"></i></span>
      </button>
    </div>
  </div>
  @endforeach
@endif
