<template>
  <div v-if="loading" class="loader"></div>
  <div v-if="!loading">
    <div class="filters__section">
      <div class="row">
        <div class="col-sm-4">
          <label class="form-label"><small>Search by name</small></label>
          <input class="form-control" type="text" v-model="searchName" placeholder="Search by name">
        </div>
        <div class="col-sm-4">
          <label class="form-label"><small>Search by family</small></label>
          <select class="form-select form-select-md mb-3" v-model="searchFamily">
            <option v-for="(family, index) in families" :key="index" :value="family.family">{{ family.family }}</option>
          </select>
        </div>
        <div class="col-sm-4">
          <button class="btn btn-success ms-5" @click="clearFilter">Clear</button>
        </div>
      </div>
    </div>
    <div v-for="fruit in paginatedData" :key="fruit.id">
      <Fruit :fruit="fruit"/>
    </div>
    <hr>
    <div v-if="!showNav">
      <button class="btn btn-primary me-3" :disabled="pageNumber === 0" @click="prevPage">
        Previous
      </button>
      <button class="btn btn-primary ms-3" :disabled="pageNumber >= pageCount -1" @click="nextPage">
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
      loading: false
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
      if(this.showNav === false || (this.showNav === true && this.searchName.length === 0 && this.searchFamily.length === 0)) {
        this.showNav = !this.showNav;
      }
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
        this.clearFilter();
        return this.fruits
            .slice(start, end);
      }
    },

  },

  async mounted() {
    this.loading = true;
    try {
      let {data} = await axios.get('/api/getfruits')
      this.fruits = data.fruits;
      this.families = data.families;
      this.loading = false;
    }catch (error){
      console.log(error);
      this.loading = false;
    }
  },
  name: "FruitsComponent"
}
</script>

<style scoped>
  button{
  width: 150px;
  }
 button:hover{
    cursor:pointer;
  }
  button:hover:disabled{
    cursor:not-allowed;
  }
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