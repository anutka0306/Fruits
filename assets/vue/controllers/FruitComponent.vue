<template>
  <div>
    {{ fruit.name }} - {{ fruit.family}}
    <button class="btn btn-light" @click="addFavorite(fruit.apiId)"><i class="text-danger" :class="favBtn"></i></button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      favorites: [],
      newFav: null,
      fruitId: null,
      favBtn: 'fa-regular fa-heart',
    }
  },
  props: {
    fruit: {
      required: true,
      type: Object
    }
  },
  methods:{
    addFavorite(fruitId){
      if(localStorage.getItem('favorites')) {
        this.favorites = JSON.parse(localStorage.getItem('favorites'));
      }
      if(this.favorites.indexOf(fruitId) !== -1) {
        let fruitIndex = this.favorites.indexOf(fruitId);
        this.favorites.splice(fruitIndex,1);
        this.favBtn = 'fa-regular fa-heart';
      }
      else {
        this.favorites.push(fruitId);
        this.favBtn = 'fa-solid fa-heart';
      }
      fruitId = null;
      this.saveFavorites();
    },
    saveFavorites(){
      const parsed = JSON.stringify(this.favorites);
      localStorage.setItem('favorites', parsed);
    }
  },
  mounted() {
    if(localStorage.getItem('favorites')) {
      this.favorites = JSON.parse(localStorage.getItem('favorites'));
      if (this.favorites.indexOf(this.fruit.apiId) !== -1) {
        this.favBtn = 'fa-solid fa-heart';
      } else {
        this.favBtn = 'fa-regular fa-heart';
      }
    }
  }
}
</script>