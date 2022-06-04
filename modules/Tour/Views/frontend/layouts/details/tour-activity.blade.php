
    <div class="makeFlex flexOne padding10 brdrContainer borderRadius4 card">
        <div class="wdth210 pointer appendRight15 vrtTop">
        <img :src="value.img_url" alt="img" class="card-image" width="100px" />
		</div>
        <div class="flexOne makeFlex column spaceBetween">
            <div>
                <div class="makeFlex">
                    <div class="flexOne">
                        <div class="makeFlex hrtlCenter appendBottom5"><div class="greyText appendBottom2 appendRight5">Activity in @{{type.location}}</div></div>
                        <p class="latoBlack blackText font18 pointer appendBottom6">@{{value.name}}</p>
                    </div>
                    <a class="btn font12 latoBold" v-if="value.must==2" @click="removeActivity($event, index, actIndex, '{{$typeActivity}}')">REMOVE</a>
                </div>
                <div class="appendBottom22">
                    <span class="makeAllInline">@{{value.desc}} </span>
                </div>
            </div>
            <div class="makeFlex spaceBetween">
                <div class="makeFlex flexOne">
                    <div class="appendRight26">
                        <p class="font10 greyText appendBottom6">DURATION</p>
                        <p class="font14 blackText">@{{value.duration}} hrs</p>
                    </div>
                    <div class="appendRight26">
                        <p class="font10 greyText appendBottom6">INCLUDES</p>
                        <p class="font14 blackText capitalizeText">@{{value.inclusions_name}}</p>
                    </div>
                    <div class="appendRight26">
                        <p class="font10 greyText appendBottom6">EXCLUDE</p>
                        <p class="font14 blackText">@{{value.exclude}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>