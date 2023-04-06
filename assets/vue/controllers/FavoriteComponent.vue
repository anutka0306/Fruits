<template>
  <div class="fav__item">
    <div class="fav__item_name">
      <h3>{{ fruit.name }}</h3>
      <small>{{ fruit.family }}</small>
    </div>
    <div class="fav__item_nutritions">
      <p>Carbohydrates: <b>{{ fruit.carbohydrates }}</b></p>
      <p>Protein: <b>{{ fruit.protein }}</b></p>
      <p>Fat: <b>{{ fruit.fat }}</b></p>
      <p>Sugar: <b>{{fruit.sugar}}</b></p>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    fruit: {
      required: true,
      type: Object
    }
  },
  name: "Favorite"
}
</script>

<style scoped>
.fav__item{
  width: 100%;
  display: flex;
  justify-content: flex-start;
  padding: 20px;
  box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
  margin-bottom: 50px;
}
.fav__item_name{
  margin-right: 50px;
  width: 50%;
}
.fav__item_name h3{
  color: darkslateblue;
  font-size: 24px;
  margin: 0 0 20px 0;
  text-transform: uppercase;
}
.fav__item_nutritions p{
  font-size: 16px;
  font-style: italic;
  color: dimgray;
}
</style>