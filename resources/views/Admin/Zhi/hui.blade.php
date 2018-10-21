<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
            <tr>
                <th>放单人</th>
                @foreach($fuserid as $f)
                <th>{{$f->fname}}</th>
                @endforeach
                <th>总计</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shopid as $s)
            <tr>
                <td>{{$s->sname}}</td>
                @foreach($s->count as $count)
                <td>{{$count}}</td>
                @endforeach
                <td>{{array_sum($s->count)}}</td>
            </tr>
            @endforeach
            <tr>
                <td>总计</td>
                @foreach($zongji as $zon)
                <td>{{$zon}}</td>
                @endforeach
                <td></td>

            </tr>
        </tbody>
    </table>
</div>