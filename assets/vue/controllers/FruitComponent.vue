<template>
  <div>
    {{ fruit.name }} - {{ fruit.family}}
    <button @click="addFavorite(fruit.apiId)">{{ favBtn }}</button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      favorites: [],
      newFav: null,
      fruitId: null,
      favBtn: 'Add to Favorite',
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
        this.favBtn = 'Add to Favorite';
      }
      else {
        this.favorites.push(fruitId);
        this.favBtn = 'Remove from Favorite';
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
        this.favBtn = 'Remove from Favorite';
      } else {
        this.favBtn = 'Add to Favorite';
      }
    }
  }
}
</script>