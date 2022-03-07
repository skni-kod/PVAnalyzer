<template>
  <div class="container">
    <div class="left">
      <div class="left-top">
         
        <!-- <img :src="logo" width="46px" height="50px" alt="Logo"> -->
        <span><i class="fa-solid fa-bolt"  width="46px" height="50px" />PV Analyzer</span>
      </div>
      <div class="logo">
        <img src="../../assets/logo.png" width="100px" height="100px" alt="Logo" /> 
        <h1> Make your life better</h1>
      </div>
    </div>
    <div class="right">
      <slot></slot>
    </div>
  </div>
</template>

<script>
import logo from '../../assets/logo.png'
export default {
    data(){
        return{
            logo: logo
        }
    }
};
</script>

<style scoped>

.container {
  width: 100%;
  display: flex;
  height: 100%;
  font-family: 'Lato', sans-serif;
    font-weight: 900;
}
.left {
  position: relative;
  width: 50%;
  background: #0934a5;
}

span{
    color: white;
}
.right {
  width: 50%;
  margin: auto;
}

.submit-button button {
  width: 100%;
  text-align: center;
  padding: 40px 0 40px 0;
  background-color: #0934a5;
  color: #ffffff;
  font-size: 24px;
  border: none;
}

.bottom-text {
  padding-top: 11px;
  margin-left: 15%;
  margin-right: 15%;
  text-align: center;
}
.bottom-text span {
  color: #0934a5;
  font-size: 18px;
}

.logo {
  /* display: block;
  text-align: center;
  margin: auto; */
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100%;
  /* padding-bottom: 37px; */
}
.logo h1 {
  color: #ffffff;
  font-size: 48px;
}
.left-top {
  position: absolute;
  display: flex;
  align-items: center;
  padding: 15px 0 0 15px;
}

.left-top span {
  color: #ffffff;
  font-size: 18px;
}

@media screen and (max-width: 650px) {
  .container {
    flex-direction: column;
  }
  .left {
    width: 100%;
  }
  .right {
    width: 100%;
  }
  
}


</style>
