<template>
  <div>
    <p>Fruits Component</p>
    <div v-for="fruit in paginatedData" :key="fruit.id">
      <Fruit :fruit="fruit"/>
    </div>
    <hr>
    <button :disabled="pageNumber === 0" @click="prevPage">
      Previous
    </button>
    <button :disabled="pageNumber >= pageCount -1" @click="nextPage">
      Next
    </button>
  </div>
</template>

<script>
import axios from 'axios'
import Fruit from './FruitComponent'
export default {
  components: {Fruit},
  data() {
    return {
      fruits:[],
      pageNumber: 0,

    }
  },
  props:{
    size:{
      type:Number,
      required:false,
      default: 10
    }
  },
  methods:{
    nextPage(){
      this.pageNumber++;
    },
    prevPage(){
      this.pageNumber--;
    }
  },
  computed:{
    pageCount(){
      let l = this.fruits.length,
          s = this.size;
      return Math.ceil(l/s);
    },
    paginatedData(){
      const start = this.pageNumber * this.size,
          end = start + this.size;
      return this.fruits
          .slice(start, end);
    }
  },

  async mounted() {
    let { data } = await axios.get('/api/getfruits')
    this.fruits = data.fruits;
  },
  name: "FruitsComponent"
}
</script>

<style scoped>
  button{
    width:100px;
    height:40px;
    background-color:#eef;
  }

  button:hover{
    cursor:pointer;
  }
  button:hover:disabled{
    cursor:not-allowed;
  }
</style>