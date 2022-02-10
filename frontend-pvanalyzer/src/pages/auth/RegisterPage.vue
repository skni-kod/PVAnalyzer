<template>
 <base-login-register>
 <div class="box">
                <div class="content">
                    <form action="">
                        <div class="form-control">
                            <label class="label-form" for="email">Email</label>
                            <input class="input-form" type="text" id="email" value="janrapo47" />
                        </div>
                        <div class="form-control">
                            <label class="label-form" for="username">Nazwa użytkownika</label>
                            <input class="input-form" type="text" id="username" value="janRapowanie47@gmail.com"/>
                        </div>
                        <div class="form-control">
                            <label class="label-form" for="password">Hasło </label>
                            <input class="input-form" type="password" id="password" value="123456"/>
                        </div>
                        <div class="form-control">
                            <label class="label-form" for="repeat-password">Powtórz hasło</label>
                            <input class="input-form" type="password" id="repeat-password" value="123456"/>
                        </div>
                        <div class="form-control-checkbox">
                            <input type="checkbox" id="statute" />
                            <label for="statute">Akceptuję <a href="">regulamin</a> </label>
                        </div>
                    </form>
                </div>
                <div class="submit-button">
                    <button>Utwórz konto</button>
                </div>
            </div>
           
            <div class="bottom-text">
                <span>Masz już konto? <a href="">Zaloguj się</a></span>
            </div>
 </base-login-register>
</template>

<script>
export default {

}
</script>

<style scoped>
.box{
    box-shadow: 0 5px 8px rgba(0, 0, 0, 0.26);
    margin: 5% 15% 0 15%;
}

.content{
    
    padding: 10px 40px 10px 40px;
    background-color: #FFFFFF;
   
}
.form-control{
    margin: 10px 0 10px 0;
}
.label-form{
    display: block;
    color: #1845BA;
    font-size: 12px;
    margin: 5px 0 5px 0;
}
.input-form{
    font-size: 12px;
    width:100%;
    border: none;
    outline: none;
    border-bottom: 1px solid black;
}

.submit-button button{
    width: 100%;
    text-align: center;
    padding: 20px 0 20px 0;
    background-color: #0934A5;
    color: #FFFFFF;
    font-size: 18px;
    font-weight: bold;
    border: none;
}
a:hover,
a:active{
color: #0044e2;
}
button:hover,
button:active {
  background-color: #0044e2;
  border-color: #0044e2;
}

.bottom-text{
    padding-top: 11px;
    margin-left: 15%;
    margin-right: 15%;
    text-align: center;
}
.bottom-text span{
    color: #0934A5;
    font-size: 12px;
}
.form-control-checkbox{
  display: flex;
  align-items: center;
}
.form-control-checkbox label{
    font-size: 12px;
    font-weight: 600;
    margin-left: 15px;
}
@media screen and (max-width: 650px) {
.bottom-text {
    margin-bottom: 20px;
  }
}
</style>