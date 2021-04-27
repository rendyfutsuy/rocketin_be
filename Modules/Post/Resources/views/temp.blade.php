<p>
    <h3><strong>{{ $location }}</strong></h3>
    <img style="width: 100%; margin-top: 20px; margin-bottom: 20px;" src="{{ $featuredUrl }}" width="100%" height="auto" />

    {{ $content }}
  
    <div style="width: 100%; margin-top: 20px; margin-bottom: 20px;">
        <div style="display: flex; flex-wrap: nowrap;">
            @foreach($images as $key => $image)
                <?php  $caption = \Illuminate\Support\Arr::get($captions, $key) ?>
                 <div 
                    style="
                        width: 210px;
                        margin-right: 10px;
                        height: 210px;
                        margin: auto;
                        margin-bottom: 35px;
                        display: block;
                        float: left;
                        background-image: url('{{ $image }}');
                        background-position: center;
                        background-origin: content-box;
                        background-size: cover;"
                >
                    @if($caption && $caption != 'null')
                    <center>
                        <div style="background-color: white; margin-top: 85%; padding: 5px 0px;"> {{$caption}} </div>
                    </center>
                    @endif
                </div>
                @if(($key+1)%3 == 0)
                    </div>
                    <div style="display: flex; flex-wrap: nowrap;">
                @endif
            @endforeach
        </div>
    </div>
  
  
    <strong>Kontak</strong>
    <br>
    <ul>
        @foreach($contacts as $key => $cont)
            <li>{{ $cont['name'] }} : {{ $cont['value']}}</li>
        @endforeach
    </ul>  

    @if(empty($contacts))
    {{ $contact }}       
    @endif
</p>