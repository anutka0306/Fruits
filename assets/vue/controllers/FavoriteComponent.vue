<template>
  <div class="fav__item">
    <div class="fav__item_name">
      <h3 class="text-info-emphasis fw-semibold text-uppercase">{{ fruit.name }}</h3>
      <small>{{ fruit.family }}</small>
    </div>
    <div class="fav__item_nutritions">
      <p>Carbohydrates: <b>{{ fruit.carbohydrates }}</b></p>
      <p>Protein: <b>{{ fruit.protein }}</b></p>
      <p>Fat: <b>{{ fruit.fat }}</b></p>
      <p>Sugar: <b>{{fruit.sugar}}</b></p>
    </div>
    <button class="btn btn-light" @click="removeFavorite(fruit.apiId)"><i class="text-danger fa-solid fa-heart"></i></button>
  </div>
</template>

<script>
export default {
  data(){
    return{
      favorites:[]
    }
  },
  props: {
    fruit: {
      required: true,
      type: Object
    }
  },

  methods:{
    removeFavorite(fruitId){
      this.$emit('remove', fruitId);
      this.$forceUpdate();
    }
  },
  mounted() {
    if(localStorage.getItem('favorites')) {
      this.favorites = JSON.parse(localStorage.getItem('favorites'));
    }
  },
  name: "Favorite"
}
</script>

<style scoped>
.fav__item{
  width: 100%;
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  padding: 20px;
  box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
  margin-bottom: 50px;
}
.fav__item_name{
  margin-right: 50px;
  width: 40%;
}
.fav__item_name h3{
  font-size: 24px;
  margin: 0 0 20px 0;
}
.fav__item_nutritions{
  width: 50%;
}
.fav__item_nutritions p{
  font-size: 16px;
  font-style: italic;
  color: dimgray;
}
</style>