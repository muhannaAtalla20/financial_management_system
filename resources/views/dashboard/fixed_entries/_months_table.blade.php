<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">يناير</th>
            <th scope="col">فبراير</th>
            <th scope="col">مارس</th>
            <th scope="col">أبريل</th>
            <th scope="col">مايو</th>
            <th scope="col">يونيو</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <input type="number" id="{{ $name }}_month-1" name="{{ $name }}_month-1" class="form-control" placeholder="0."  @disabled($month > 1) value="{{$controller->getFixedEntriesFialds($fixed_entrie['employee']->id,$year,'01',$name)}}">
            </td>
            <td>
                <input type="number" id="{{ $name }}_month-2" name="{{ $name }}_month-2" class="form-control" placeholder="0." @disabled($month > 2) value="{{$controller->getFixedEntriesFialds($fixed_entrie['employee']->id,$year,'02',$name)}}">
            </td>
            <td>
                <input type="number" id="{{ $name }}_month-3" name="{{ $name }}_month-3" class="form-control" placeholder="0." @disabled($month > 3) value="{{$controller->getFixedEntriesFialds($fixed_entrie['employee']->id,$year,'03',$name)}}">
            </td>
            <td>
                <input type="number" id="{{ $name }}_month-4" name="{{ $name }}_month-4" class="form-control" placeholder="0." @disabled($month > 4) value="{{$controller->getFixedEntriesFialds($fixed_entrie['employee']->id,$year,'04',$name)}}">
            </td>
            <td>
                <input type="number" id="{{ $name }}_month-5" name="{{ $name }}_month-5" class="form-control" placeholder="0." @disabled($month > 5) value="{{$controller->getFixedEntriesFialds($fixed_entrie['employee']->id,$year,'05',$name)}}">
            </td>
            <td>
                <input type="number" id="{{ $name }}_month-6" name="{{ $name }}_month-6" class="form-control" placeholder="0." @disabled($month > 6) value="{{$controller->getFixedEntriesFialds($fixed_entrie['employee']->id,$year,'06',$name)}}">
            </td>
        </tr>
    </tbody>
</table>
<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">يوليو</th>
            <th scope="col">أغسطس</th>
            <th scope="col">سبتمبر</th>
            <th scope="col">أكتوبر</th>
            <th scope="col">نوفمبر</th>
            <th scope="col">ديسمبر</th>
        </tr>
    </thead>
    <tbody>
        {{--  value="{{getFixedEntriesFialds($fixed_entrie['employee']->id,$year,'07',$name)}}"  --}}
        <tr>
            <td>
                <input type="number" id="{{ $name }}_month-7" name="{{ $name }}_month-7" class="form-control" placeholder="0." value="{{$controller->getFixedEntriesFialds($fixed_entrie['employee']->id,$year,'07',$name)}}"  @disabled($month > 7)>
            </td>
            <td>
                <input type="number" id="{{ $name }}_month-8" name="{{ $name }}_month-8" class="form-control" placeholder="0." value="{{$controller->getFixedEntriesFialds($fixed_entrie['employee']->id,$year,'08',$name)}}" @disabled($month > 8)>
            </td>
            <td>
                <input type="number" id="{{ $name }}_month-9" name="{{ $name }}_month-9" class="form-control" placeholder="0." value="{{$controller->getFixedEntriesFialds($fixed_entrie['employee']->id,$year,'09',$name)}}" @disabled($month > 9)>
            </td>
            <td>
                <input type="number" id="{{ $name }}_month-10" name="{{ $name }}_month-10" class="form-control" placeholder="0." value="{{$controller->getFixedEntriesFialds($fixed_entrie['employee']->id,$year,'10',$name)}}" @disabled($month > 10)>
            </td>
            <td>
                <input type="number" id="{{ $name }}_month-11" name="{{ $name }}_month-11" class="form-control" placeholder="0." value="{{$controller->getFixedEntriesFialds($fixed_entrie['employee']->id,$year,'11',$name)}}" @disabled($month > 11)>
            </td>
            <td>
                <input type="number" id="{{ $name }}_month-12" name="{{ $name }}_month-12" class="form-control" placeholder="0." value="{{$controller->getFixedEntriesFialds($fixed_entrie['employee']->id,$year,'12',$name)}}" @disabled($month > 12)>
            </td>
        </tr>
    </tbody>
</table>
