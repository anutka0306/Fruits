<template>
  <div v-for="(fav, index) in favorites" :key="fav.apiId">
    <Favorite :fruit="fav"/>
  </div>
<!--  <p v-for="(fav, index) in favorites">{{ fav.name }}</p>-->
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
    }
  },
  props:{

  },
  async mounted() {
    this.favoritesIds = JSON.parse(localStorage.getItem('favorites'));
    let { data } = await axios.get('/api/getfavorites', {
      params:{
        'fruits': this.favoritesIds
      }
    });
    this.favorites = data.favorites;
  },
  name: "FavoritesComponent"
}
</script>

<style scoped>

</style>