@extends('apps::dashboard.layouts.app')
@section('title', __('user::dashboard.users.create.title'))
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.index.title') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{ url(route('dashboard.users.index')) }}">
                        {{__('user::dashboard.users.index.title')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('user::dashboard.users.create.title')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            <form id="form" role="form" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="{{route('dashboard.users.store')}}">
                @csrf

                <div class="col-md-12">

                    {{-- RIGHT SIDE --}}
                    <div class="col-md-3">
                        <div class="panel-group accordion scrollable" id="accordion2">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a class="accordion-toggle"></a></h4>
                                </div>
                                <div id="collapse_2_1" class="panel-collapse in">
                                    <div class="panel-body">
                                        <ul class="nav nav-pills nav-stacked">
                                            <li class="active">
                                                <a href="#global_setting" data-toggle="tab">
                                                    {{ __('user::dashboard.users.create.form.general') }}
                                                </a>
                                            </li>


                                            <li class="">
                                                <a href="#currentSubscription" data-toggle="tab">
                                                    {{ __('user::dashboard.users.update.form.currentSubscription.tab') }}
                                                </a>
                                            </li>


                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- PAGE CONTENT --}}
                    <div class="col-md-9">
                        <div class="tab-content">

                            {{-- CREATE office --}}
                            <div class="tab-pane  active fade in" id="global_setting">
                                <h3 class="page-title">{{__('user::dashboard.users.create.form.general')}}</h3>
                                <div class="col-md-10">


                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('user::dashboard.users.create.form.name')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="name" class="form-control" data-name="name">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('user::dashboard.users.create.form.email')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="email" name="email" class="form-control" data-name="email">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('user::dashboard.users.create.form.mobile')}}
                                        </label>
                                        <div class="col-md-3">
                                            <select name="phone_code" class="form-control select2" data-name="phone_code" >
                                                <option value=""></option>
                                                @foreach ($phoneCodes as $phoneCode)
                                                @if (!empty($phoneCode['calling_code'][0]))
                                                <option value="{{ $phoneCode['calling_code'][0] }}" @if( $phoneCode['calling_code'][0] == "965" ) selected @endif>
                                                    {{ $phoneCode['flag'] .' '.$phoneCode['code'] . ' +' . $phoneCode['calling_code'][0] }}
                                                </option>
                                                @endif
                                                @endforeach
                                            </select>
                                            <div class="help-block"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="mobile" class="form-control" data-name="mobile">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('user::dashboard.users.create.form.password')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input
                                            
                                            type="password" name="password" class="form-control" data-name="password" autocomplete="new-password" >
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('user::dashboard.users.create.form.confirm_password')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="password" name="confirm_password" class="form-control" data-name="confirm_password">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('user::dashboard.users.create.form.image')}}
                                        </label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <a data-input="image" data-preview="holder" class="btn btn-primary ">
                                                        <i class="fa fa-picture-o"></i>
                                                        {{__('apps::dashboard.buttons.upload')}}
                                                    </a>
                                                </span>
                                                <input name="image" class="form-control image" type="file" >

                                            </div>
                                            <span class="holder" style="margin-top:15px;max-height:100px;">
                                            </span>
                                            <input type="hidden" data-name="image">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('user::dashboard.users.create.form.status')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="checkbox" class="make-switch" checked id="test" data-size="small" name="is_active">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('user::dashboard.users.create.form.is_verified')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="checkbox" class="make-switch" checked id="is_verified" data-size="small" name="is_verified">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>


                                </div>
                            </div>

                            <div class="tab-pane  fade in office-data" id="currentSubscription">
                                <h3 class="page-title">{{ __('user::dashboard.users.update.form.currentSubscription.tab') }}</h3>
                                <div class="col-md-10">


                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('user::dashboard.users.create.form.have_subscription')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="checkbox" class="make-switch"  id="have_subscription" data-size="small" name="have_subscription">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('user::dashboard.users.create.form.package_id')}}
                                        </label>
                                        <div class="col-md-9">

                                            <select name="package_id" class="form-control selected" data-name="package_id">
                                                @foreach ($packages as $package )
                                                    <option value="{{$package->id}}"

                                                             > {{$package->title}}</option>
                                                @endforeach
                                            </select>

                                            <div class="help-block"></div>
                                        </div>
                                        <label>{{ __('user::dashboard.users.update.form.currentSubscription.use_pakcage_info') }}</label>
                                        <input type="checkbox" id="use_pakcage_info" checked value="1" name="use_pakcage_info" />
                                    </div>

                                    <div class="sub-data" style="display: none">
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('user::dashboard.users.update.form.currentSubscription.current_use') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="subscription[current_use]"  class="form-control" data-name="subscription.current_use">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('user::dashboard.users.update.form.currentSubscription.max_use') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="subscription[max_use]"  class="form-control" data-name="subscription.max_use">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('user::dashboard.users.update.form.currentSubscription.duration_of_ads') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="number" name="subscription[duration_of_ads]"  class="form-control" data-name="subscription.duration_of_ads">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('user::dashboard.users.update.form.currentSubscription.start_at') }}
                                            </label>

                                            <div class="col-md-9">
                                                <div class="input-group input-medium date date-picker" data-name="subscription.start_at" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                    <input type="text" class="form-control"
                                                            name="subscription[start_at]"
                                                            >
                                                    <span class="input-group-btn">
                                                        <button class="btn default" type="button">
                                                            <i class="fa fa-calendar"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('user::dashboard.users.update.form.currentSubscription.end_at') }}
                                            </label>

                                            <div class="col-md-9">
                                                <div class="input-group input-medium date date-picker" data-name="subscription.end_at" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                    <input type="text" class="form-control"
                                                            name="subscription[end_at]"
                                                          >
                                                    <span class="input-group-btn">
                                                        <button class="btn default" type="button">
                                                            <i class="fa fa-calendar"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('user::dashboard.users.update.form.currentSubscription.money') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="subscription[money]" min="0" value="0" class="form-control" data-name="office.money">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>


                        </div>
                    </div>

                    {{-- PAGE ACTION --}}
                    <div class="col-md-12">
                        <div class="form-actions">
                            @include('apps::dashboard.layouts._ajax-msg')
                            <div class="form-group">
                                <button type="submit" id="submit" class="btn btn-lg blue">
                                    {{__('apps::dashboard.buttons.add')}}
                                </button>
                                <a href="{{url(route('dashboard.users.index')) }}" class="btn btn-lg red">
                                    {{__('apps::dashboard.buttons.back')}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('scripts')

<script>
    $(function() {
      var typeOfUser = $("#userType")
      var have_subscription = $("#have_subscription");
      var use_pakcage_info = $("#use_pakcage_info")
      var currentSubscription = $("#currentSubscription")
      var subscriptionData    = $(".sub-data")


      //hande if use_package_info_check
      use_pakcage_info.change(function(){
          handleEditSubscription()
      })


      have_subscription.on("switchChange.bootstrapSwitch",function(event, state){
        handlHaveSubscription(state)
      })

      function handlHaveSubscription(have){
        currentSubscription.find("input , textarea, .selected, select").prop('disabled', !have)
        handleEditSubscription()
      }

      handlHaveSubscription(false)
      handleEditSubscription()

      function handleEditSubscription(){
        if(use_pakcage_info.is(":checked") ||  use_pakcage_info.attr("disabled")){
            subscriptionData.find("input , textarea, .selected, select").prop('disabled', true);
            subscriptionData.hide();
          }else{
            subscriptionData.find("input , textarea, .selected, select").prop('disabled', false);
            subscriptionData.show()
          }
      }

    });


</script>

@stop
