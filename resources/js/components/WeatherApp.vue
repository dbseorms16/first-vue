<template>
  <div class="text-white mb-8">
    <div class="places-input text-gray-800">
      <input type="search" id="address-input" placeholder="Where are we going?" />
      <p>Selected: <strong id="address-value">none</strong></p>
    </div>
    <div class="weather-container font-sans w-128 max-w-lg overflow-hidden
       bg-blue-700 shadow-lg mt-4 rounded-lg">
      <div class="current-weather flex items-center justify-between px-6 py-8">
        <div class="flex items-center">
          <div>
            <div class="text-6xl font-semibold">{{currentTemperature.actual}}도</div>
            <div class="">체감온도 : {{currentTemperature.feel}} 도</div>
          </div>
          <div class="mx-5">
            <div class="font-semibold">{{currentTemperature.summary}}</div>
            <div >{{this.location.name}}</div>


          </div>
        </div>
        <div>
          <img :src="this.currentTemperature.icon" alt=""></div>
      </div>
      <div class="future-weather text-sm bg-blue-500 px-8 py-6 overflow-hidden">
        <div v-for="(day,index) in currentTemperature.daily" :key="day.dt_txt"
             class="flex items-center "
             :class="{'mt-8': index > 0}"
              v-if="index < 10"
        >
          <div class="w-1/6 text-lg text-gray-200">{{toDayOfWeek(day.dt_txt)}}</div>
          <div class="w-4/6 px-5 flex item-center">
            <div><img :src="showIcon(day.weather[0].icon)" alt=""></div>
            <div class="ml-3">{{day.weather[0].description}}</div>
          </div>
          <div class="w-1/6 text-right">
            <div>{{Math.round(day.main.temp_min-273.15)}}</div>
            <div>{{Math.round(day.main.temp_max-273.15)}}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    mounted() {
      this.fetchData();

      var placesAutocomplete = places({
        appId: 'plJAEUFD5OCL',
        apiKey: 'f8a6d448e0a442aa0ac313dd6202f62b',
        container: document.querySelector('#address-input')
      }).configure({
        type: 'city',
        aroundLatLngViaIP: false,
      });
      var $address = document.querySelector('#address-value')
      placesAutocomplete.on('change', (e) => {
        $address.textContent = e.suggestion.value;
        this.location.name = `${e.suggestion.name}, ${e.suggestion.country}`;
        this.location.lat = e.suggestion.latlng.lat;
        this.location.lng = e.suggestion.latlng.lng;

      });
      placesAutocomplete.on('clear', function () {
        $address.textContent = 'none';
      });
    },
    watch: {
      location: {
        handler(newValue, oldValue) {
          this.fetchData()
        },
        deep: true
      }
    },
    data() {
      return {
        currentTemperature: {
          actual: '',
          feel: '',
          summary: "",
          icon: '',
          src: "",
          daily: [],
        },
        location: {
          'name': '나주시, 대한민국',
          'lat': 35.0159,
          'lng': 126.711
        }
      }
    },
    methods: {
      fetchData() {
        fetch(`/api/weather?lat=${this.location.lat}&lng=${this.location.lng}`)
          .then(response => response.json())
          .then(data => {
            this.currentTemperature.actual = Math.round(data.list[0].main.temp - 273.15);
            this.currentTemperature.feel = Math.round(data.list[0].main.feels_like - 273.15);
            this.currentTemperature.summary = data.list[0].weather[0].main;
            this.currentTemperature.icon = this.showIcon(data.list[0].weather[0].icon);
            this.currentTemperature.daily = data.list;
          })
        // this.$nextTick(()=>{}) 이 함수 알아보기
      },
      showIcon(icon) {
        this.src = `/img/${icon}@2x.png`;
        return this.src;
      },
      toDayOfWeek(timeStamp){
        const newDate = new Date(timeStamp);
        const weeks = ['일','월','화','수','목','금','토'];
        const dayOfWeek = weeks[newDate.getDay()];
        const hours = newDate.getHours();
        const toDayOfTime = dayOfWeek+"/"+hours+"시";
        return toDayOfTime;
      }
    }
  }
</script>

<style scoped>

</style>
