<template>
  <div>
    <p>Fruits Component</p>
    <div class="filters__section">
      <input type="text" v-model="searchName" placeholder="Search by name">
      <select v-model="searchFamily">
        <option v-for="(family, index) in families" :key="index" :value="family.family">{{ family.family }}</option>
      </select>
      <button @click="clearFilter">Clear</button>
    </div>
    <div v-for="fruit in paginatedData" :key="fruit.id">
      <Fruit :fruit="fruit"/>
    </div>
    <hr>
    <div v-if="!showNav">
      <button :disabled="pageNumber === 0" @click="prevPage">
        Previous
      </button>
      <button :disabled="pageNumber >= pageCount -1" @click="nextPage">
        Next
      </button>
    </div>
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
      families:[],
      pageNumber: 0,
      searchName:'',
      searchFamily:'',
      showNav:false,
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
    },
    clearFilter(){
      this.searchName = '';
      this.searchFamily = '';
      if(this.showNav === true) {
        this.showNav = !this.showNav;
      }
    },
    hideNav(){
      this.showNav = !this.showNav;
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
      if(this.searchName.length > 0 && this.searchFamily.length > 0){
        this.hideNav();
        return this.fruits.filter(fruit => {
          return fruit.name.toUpperCase().indexOf(this.searchName.toUpperCase()) !== -1 && fruit.family.toUpperCase().indexOf(this.searchFamily.toUpperCase()) !== -1;
        });
      }
      else if(this.searchName.length > 0){
        this.hideNav();
        return this.fruits.filter(fruit => {
          return fruit.name.toUpperCase().indexOf(this.searchName.toUpperCase()) !== -1;
        });
      }
      else if(this.searchFamily.length > 0){
        this.hideNav();
        return this.fruits.filter(fruit => {
          return fruit.family.toUpperCase().indexOf(this.searchFamily.toUpperCase()) !== -1;
        });
      }
      else {
        return this.fruits
            .slice(start, end);
      }
    },

  },

  async mounted() {
    let { data } = await axios.get('/api/getfruits')
    this.fruits = data.fruits;
    this.families = data.families;
    console.log(this.families);
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