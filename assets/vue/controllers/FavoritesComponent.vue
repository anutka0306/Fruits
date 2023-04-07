<template>
  <div>
    <div v-for="(fav, index) in favorites" :key="fav.apiId">
      <Favorite :fruit="fav" @remove="removeFromList"/>
    </div>
    <div class="nutrition_total">
      <h3>Nutrition Total</h3>
      <p>Carbohydrates: <b>{{ total.carbohydrates }}</b></p>
      <p>Protein: <b>{{ total.protein }}</b></p>
      <p>Fat: <b>{{ total.fat }}</b></p>
      <p>Sugar: <b>{{ total.sugar }}</b></p>
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
      console.log(this.favorites);
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
    this.favoritesIds = JSON.parse(localStorage.getItem('favorites'));
    let { data } = await axios.get('/api/getfavorites', {
      params:{
        'fruits': this.favoritesIds
      }
    });
    this.favorites = data.favorites;
    console.log(this.favorites);
    this.getNutritionsTotal();
  },
  name: "FavoritesComponent"
}
</script>

<style scoped>

</style>