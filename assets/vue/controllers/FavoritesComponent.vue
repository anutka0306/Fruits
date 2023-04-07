<template>
  <div v-if="loading" class="loader"></div>
  <div v-if="!loading">
    <div v-for="(fav, index) in favorites" :key="fav.apiId">
      <Favorite :fruit="fav" @remove="removeFromList"/>
    </div>
    <div class="card">
      <div class="card-body">
        <h3 class="card-title text-danger mb-3 text-uppercase fw-semibold fs-5 text">Nutrition Total</h3>
        <p class="card-text fst-italic fs-6 text">Carbohydrates: <b>{{ total.carbohydrates }}</b></p>
        <p class="card-text fst-italic fs-6 text">Protein: <b>{{ total.protein }}</b></p>
        <p class="card-text fst-italic fs-6 text">Fat: <b>{{ total.fat }}</b></p>
        <p class="card-text fst-italic fs-6 text">Sugar: <b>{{ total.sugar }}</b></p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Favorite from "./FavoriteComponent";
export default {
  components: {Favorite},
  data(){
    return{
      favoritesIds:[],
      favorites:[],
      total:[],
      loading: false
    }
  },
  props:{

  },
  methods:{
    removeFromList(id) {
      if(localStorage.getItem('favorites')) {
        this.favoritesIds = JSON.parse(localStorage.getItem('favorites'));
      }
      let fruitIndex = this.favoritesIds.indexOf(id);
      if(this.favoritesIds.indexOf(id) !== -1) {
        this.favoritesIds.splice(fruitIndex,1);
      }
      this.favorites.forEach(function (item, index, object){
        if(item.apiId == id){
          object.splice(index, 1);
        }
      });
      this.saveFavorites();
      this.getNutritionsTotal();
    },
    saveFavorites(){
      const parsed = JSON.stringify(this.favoritesIds);
      localStorage.setItem('favorites', parsed);
    },
    getNutritionsTotal(){
      let carbohydrates = 0;
      let protein = 0;
      let fat = 0;
      let sugar = 0;
      this.favorites.forEach(function (item){
        carbohydrates += item.carbohydrates;
        protein += item.protein;
        fat += item.fat;
        sugar += item.sugar;
      });
      this.total['carbohydrates'] = carbohydrates.toFixed(2);
      this.total['protein'] = protein.toFixed(2);
      this.total['fat'] = fat.toFixed(2);
      this.total['sugar'] = sugar.toFixed(2);
    }
  },

  async mounted() {
    this.loading = true;
    try {
      this.favoritesIds = JSON.parse(localStorage.getItem('favorites'));
      let {data} = await axios.get('/api/getfavorites', {
        params: {
          'fruits': this.favoritesIds
        }
      });
      this.favorites = data.favorites;
      this.getNutritionsTotal();
      this.loading = false;
    }catch (error){
      console.log(error);
      this.loading = false;
    }
  },
  name: "FavoritesComponent"
}
</script>

<style scoped>
.loader {
  border: 16px solid #f3f3f3;
  border-top: 16px solid #3498db;
  border-radius: 50%;
  width: 36px;
  height: 36px;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>