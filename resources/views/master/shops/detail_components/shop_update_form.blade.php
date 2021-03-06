<div class="container">
    <div class="row">

        <div class="col-md-12">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form class="form-horizontal" role="form" method="POST" action="{{ request()->url() }}">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="reg_name" class="col-md-4 control-label">reg_name</label>
                    <div class="col-md-6">
                        <input id="reg_name" type="text" class="form-control" name="reg_name"
                               value="{{ $shop->reg_name }}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="company_name" class="col-md-4 control-label">company_name</label>
                    <div class="col-md-6">
                        <input id="company_name" type="text" class="form-control" name="company_name"
                               value="{{ $shop->company_name }}"
                        />
                    </div>
                </div>
                <div class="form-group">
                    <label for="address" class="col-md-4 control-label">address</label>
                    <div class="col-md-6">
                        <input id="address" type="text" class="form-control" name="address"
                               value="{{ $shop->address }}"
                        />
                    </div>
                </div>
                <div class="form-group">
                    <label for="tel" class="col-md-4 control-label">tel</label>
                    <div class="col-md-6">
                        <input id="tel" type="text" class="form-control" name="tel"
                               value="{{ $shop->tel }}"
                        />
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-md-4 control-label">email</label>
                    <div class="col-md-6">
                        <input id="email" type="text" class="form-control" name="email"
                               value="{{ $shop->email }}"
                        />
                    </div>
                </div>
                <div class="form-group">
                    <label for="staff" class="col-md-4 control-label">staff</label>
                    <div class="col-md-6">
                        <input id="staff" type="text" class="form-control" name="staff"
                               value="{{ $shop->staff }}"
                        />
                    </div>
                </div>
                <div class="form-group">
                    <label for="staff_contact" class="col-md-4 control-label">staff_contact</label>
                    <div class="col-md-6">
                        <input id="staff_contact" type="text" class="form-control" name="staff_contact"
                               value="{{ $shop->staff_contact }}"
                        />
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-md-8 col-md-offset-6">
                        <button type="submit" class="btn btn-warning">
                            編集
                        </button>

                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
<script>
    @if($update_success = session('update_success'))
        notifySuccess("{{ session('message') }}");
    @else
        notifyFail("{{ session('message') }}");
    @endif
</script>