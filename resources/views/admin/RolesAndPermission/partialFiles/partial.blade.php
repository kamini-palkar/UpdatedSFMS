<style>
.custom-checkbox-group {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    border: 1px dashed lightblue;
    padding: 20px;
    margin-left: -20px;
}

.form-check {
    margin-right: 10px;
}

.form-check-input {
    width: 18px;
    height: 18px;
    margin-top: 3px;
}

.form-check-label {
    margin-top: 1px;
}
</style>

<label class="fs-6 fw-bold form-label mt-3">
    <span class="border-span" style="margin-left:-20px;">❂ Permissions :</span>
</label>


<div class="custom-checkbox-group">
    @foreach ($permission_data as $print)
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="check{{ $print->id }}" value="{{ $print->id }}"
            {{ in_array($print->id, $rolepermission) ? 'checked' : '' }} name="permission[]">
        <label class="form-check-label" for="check{{ $print->id }}">
            <span style=" border: 1px dashed lightgrey; padding:5px;">{{ strtoupper($print->name)  }}</span>
        </label>
    </div>
    @endforeach
</div>