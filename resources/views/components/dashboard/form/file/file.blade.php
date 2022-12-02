@props([
    'name' ,
    'label' ,
    'id'   ,
    'default_image'
 ])
<div class="form-group">
    <div class="custom-file">
        <input type="file" name="{{ $name }}" class="custom-file-input"/>
        <label class="custom-file-label" for="customفایل">انتخاب فایل</label>
    </div>
    @error($name)
         <small class="text-danger">{{$message}}</small>
    @enderror
</div>
