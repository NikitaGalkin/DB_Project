using System.Net;
using System.Security.Cryptography;
using System.Text;

namespace ServerLibrary
{
    public class cUserAPI
    {
        public cConnectAPI connectAPI = new cConnectAPI();
        //Ключ пароль для криптования
        private string crypte_pass = "******";
        //Генерация хэша SHA256
        SHA256 mySHA256 = SHA256Managed.Create();

        /*Crypte-Encrypte в AES256*/
        private string EncrypteStr(string data)
        {
            //Переводим наш ключ пароль в хэш SHA256
            byte[] crypte_key = mySHA256.ComputeHash(Encoding.ASCII.GetBytes(crypte_pass));
            //Наш ключ в байтах
            byte[] crypte_byte = new byte[16] { 0x0, 0x0, 0x0, 0x0, 0x0, 0x0, 0x0, 0x0, 0x0, 0x0, 0x0, 0x0, 0x0, 0x0, 0x0, 0x0 };
            return WebUtility.UrlEncode(connectAPI.EncryptString(data, crypte_key, crypte_byte));
        }
        private string DecrypteStr(string data)
        {
            //Переводим наш ключ пароль в хэш SHA256
            byte[] crypte_key = mySHA256.ComputeHash(Encoding.ASCII.GetBytes(crypte_pass));
            //Наш ключ в байтах
            byte[] crypte_byte = new byte[16] { 0x0, 0x0, 0x0, 0x0, 0x0, 0x0, 0x0, 0x0, 0x0, 0x0, 0x0, 0x0, 0x0, 0x0, 0x0, 0x0 };
            return connectAPI.DecryptString(data, crypte_key, crypte_byte);
        }

        /*Отправка на кода на почту*/
        //Email - почта
        //code - код востановления
        public void sendEmail(string Email, string code){
            string request_data = "email=" + Email + "&rcode=" + code;
            connectAPI.RequestPOST("app_lib/send_mail.php", request_data);
        }

        /*Создания ссылки для товара*/
        //shop_id - айди магазина
        //item_code - код товара
        //reffer - пустой если магазин, если для партнера вводим ник партнера
        public string generateLink(string shop_id, string item_code, string reffer = ""){
            return "https://npanel.ru/CourseWork/index.php?shop_id=" + EncrypteStr(shop_id) + "&item_code=" + EncrypteStr(item_code) + (reffer != "" ? ("&reffer=" + reffer) : "");
        }

        /*Удаление существуешего промокода*/
        //succses - сохранил
        //fail - ошибка
        //shop_id - айди магазина
        //spromo - промокод скидки
        //spromoper - процент скидки(целые числа 15 примеру)
        //spromod - дата окончания(dd.mm.yyyy)
        public string delPromocode(string shop_id, string spromo)
        {
            string request_data = "metreq=" + EncrypteStr("delprm") + "&itmshpid=" + EncrypteStr(shop_id) + "&spromo=" + EncrypteStr(spromo);
            string requst_ans = connectAPI.RequestPOST("app_lib/shop_controller.php", request_data);
            return DecrypteStr(requst_ans);
        }

        /*Обновление существуешего промокода*/
        //succses - сохранил
        //fail - ошибка
        //shop_id - айди магазина
        //spromo - промокод скидки
        //spromoper - процент скидки(целые числа 15 примеру)
        //spromod - дата окончания(dd.mm.yyyy)
        public string setPromocode(string shop_id, string spromo, string spromoper, string spromod)
        {
            string request_data = "metreq=" + EncrypteStr("updprm") + "&itmshpid=" + EncrypteStr(shop_id) + "&spromo=" + EncrypteStr(spromo)
                + "&spromoper=" + EncrypteStr(spromoper) + "&spromod=" + EncrypteStr(spromod);
            string requst_ans = connectAPI.RequestPOST("app_lib/shop_controller.php", request_data);
            return DecrypteStr(requst_ans);
        }

        /*Создание нового промокода*/
        //succses - сохранил
        //fail - ошибка
        //shop_id - айди магазина
        //spromo - промокод скидки
        //spromoper - процент скидки(целые числа 15 примеру)
        //spromod - дата окончания(dd.mm.yyyy)
        public string addPromocode(string shop_id, string spromo, string spromoper, string spromod)
        {
            string request_data = "metreq=" + EncrypteStr("addprm") + "&itmshpid=" + EncrypteStr(shop_id) + "&spromo=" + EncrypteStr(spromo)
                + "&spromoper=" + EncrypteStr(spromoper) + "&spromod=" + EncrypteStr(spromod);
            string requst_ans = connectAPI.RequestPOST("app_lib/shop_controller.php", request_data);
            return DecrypteStr(requst_ans);
        }

        /*Берем список промокодов магаза*/
        //shop_id - айди магазина
        //promo_data:percent_data:promo_expired
        public string getPromocode(string shop_id)
        {
            string request_data = "metreq=" + EncrypteStr("getprm") + "&itmshpid=" + EncrypteStr(shop_id);
            string requst_ans = connectAPI.RequestPOST("app_lib/shop_controller.php", request_data);
            return DecrypteStr(requst_ans);
        }

        /*Берем список продаж по коду товара*/
        //shop_id - айди магазина
        //itm_code - код товара
        //item_price:item_seller:item_percent:sell_data
        public string getItemSells(string shop_id, string itm_code)
        {
            string request_data = "metreq=" + EncrypteStr("getitmsel") + "&itmshpid=" + EncrypteStr(shop_id) + "&itmcd=" + EncrypteStr(itm_code);
            string requst_ans = connectAPI.RequestPOST("app_lib/shop_controller.php", request_data);
            return DecrypteStr(requst_ans);
        }

        /*Берем список ключей по номеру магаза и коду товара*/
        //shop_id - айди магазина
        //itm_code - код товара
        //Вращает ключи товара item_key 
        public string getItemKey(string shop_id, string itm_code)
        {
            string request_data = "metreq=" + EncrypteStr("getitmk") + "&itmshpid=" + EncrypteStr(shop_id) + "&itmcd=" + EncrypteStr(itm_code);
            string requst_ans = connectAPI.RequestPOST("app_lib/shop_controller.php", request_data);
            return DecrypteStr(requst_ans);
        }

        /*Удаляем ключ товара из бд магазина*/
        //succses - сохранил
        //fail - ошибка
        //shop_id - айди магазина
        //itm_code - код товара
        //itm_key - ключ товара
        public string deleteItemKey(string shop_id, string itm_code, string itm_key)
        {
            string request_data = "metreq=" + EncrypteStr("delk") + "&itmshpid=" + EncrypteStr(shop_id) + "&itmcd=" + EncrypteStr(itm_code) + "&itmk=" + EncrypteStr(itm_key);
            string requst_ans = connectAPI.RequestPOST("app_lib/shop_controller.php", request_data);
            return DecrypteStr(requst_ans);
        }

        /*Добавляем ключ товара в бд магазина*/
        //succses - сохранил
        //fail - ошибка
        //key_full - есть ключ с такими данными
        //shop_id - айди магазина
        //itm_code - код товара
        //itm_key - ключ товара
        public string addItemKey(string shop_id, string itm_code, string itm_key)
        {
            string request_data = "metreq=" + EncrypteStr("setk") + "&itmshpid=" + EncrypteStr(shop_id) + "&itmcd=" + EncrypteStr(itm_code) + "&itmk=" + EncrypteStr(itm_key);
            string requst_ans = connectAPI.RequestPOST("app_lib/shop_controller.php", request_data);
            return DecrypteStr(requst_ans);
        }

        /*Берем список товаров*/
        //item_name:item_code:item_price:item_inst:item_status
        //shop_id - айди магазина
        public string getItem(string shop_id)
        {
            string request_data = "metreq=" + EncrypteStr("getitm") + "&itmshpid=" + EncrypteStr(shop_id);
            string requst_ans = connectAPI.RequestPOST("app_lib/shop_controller.php", request_data);
            return DecrypteStr(requst_ans);
        }

        /*Обновляем товар магазина в бд*/
        //itm_full - есть товар с таким именем в одном магазине
        //succses - сохранил
        //fail - ошибка
        //shop_id - айди магазина
        //itm_name - имя товара
        //itm_code - код товара
        //itm_price - цена товара
        //itm_inst - инструкция товара
        //itm_status - статус товара 1 - включен 0 - выключен
        public string setNItem(string shop_id, string itm_name, string itm_code, string itm_price, string itm_inst, string itm_status)
        {
            string request_data = "metreq=" + EncrypteStr("upditm") + "&itmshpid=" + EncrypteStr(shop_id) + "&itmnm=" + EncrypteStr(itm_name)
                + "&itmcd=" + EncrypteStr(itm_code) + "&itmpr=" + EncrypteStr(itm_price) + "&itminst=" + EncrypteStr(itm_inst) + "&itmsts=" + EncrypteStr(itm_status);
            string requst_ans = connectAPI.RequestPOST("app_lib/shop_controller.php", request_data);
            return DecrypteStr(requst_ans);
        }

        /*Сохраненям товар магазина в бд*/
        //succses - сохранил
        //fail - ошибка
        //shop_id - айди магазина
        //itm_name - имя товара
        //itm_price - цена товара
        //itm_inst - инструкция товара
        public string addNItem(string shop_id, string itm_name, string itm_price, string itm_inst)
        {
            string request_data = "metreq=" + EncrypteStr("setitm") + "&itmshpid=" + EncrypteStr(shop_id) + "&itmnm=" + EncrypteStr(itm_name) + "&itmcd=" 
                + EncrypteStr(connectAPI.generateMD5(itm_name)) + "&itmpr=" + EncrypteStr(itm_price) + "&itminst=" + EncrypteStr(itm_inst);
            string requst_ans = connectAPI.RequestPOST("app_lib/shop_controller.php", request_data);
            return DecrypteStr(requst_ans);
        }

        /*Сохраненям данные и ключи магазина*/
        //succses - сохранил
        //fail - ошибка
        //shop_id - айди магазина
        //bottoken - токен телеграмм бота
        //chatid - id чата в телеграмме
        //anykey - токен ключа AnyPay
        //any_id - id шопа в AnyPay
        //cardkey -  токен ключа CardLink
        //card_id - id шопа в CardLink
        //freekey -  токен ключа FreeKassa
        //fk_id - id шопа в FreeKassa
        public string setShopAPI(string shop_id, string bottoken, string chatid, string anykey, string any_id,
            string cardkey, string card_id, string freekey, string fk_id)
        {
            string request_data = "metreq=" + EncrypteStr("insinf") + "&usrshpl=" + EncrypteStr(shop_id) + "&btkn=" + EncrypteStr(bottoken) + "&btid=" + EncrypteStr(chatid)
                + "&akey=" + EncrypteStr(anykey) + "&aid=" + EncrypteStr(any_id) + "&ckey=" + EncrypteStr(cardkey) + "&cid=" + EncrypteStr(card_id) + "&fkey=" +
                EncrypteStr(freekey) + "&fid=" + EncrypteStr(fk_id);
            string requst_ans = connectAPI.RequestPOST("app_lib/user_edit_form.php", request_data);
            return DecrypteStr(requst_ans);
        }

        /*Сохраненям логотип магазина в бд после загрузки на хост*/
        //succses - сохранил
        //fail - ошибка
        //shop_id - айди магазина
        //photo_data - Имя фотки
        //Нужно доработать загрузку, сделаю на днях
        public string setNPhoto(string shop_id, string photo_data)
        {
            string request_data = "metreq=" + EncrypteStr("insph") + "&usrshpl=" + EncrypteStr(shop_id) + "&usrimg=" + EncrypteStr(photo_data);
            string requst_ans = connectAPI.RequestPOST("app_lib/user_edit_form.php", request_data);
            return DecrypteStr(requst_ans);
        }

        //Загрука лого на сервер
        public string loadPhoto(string file_path)
        {
            WebClient Client = new WebClient();
            Client.Headers.Add("Content-Type", "binary/octet-stream");
            byte[] result = Client.UploadFile("https://npanel.ru/CourseWork/app_lib/upload_photo.php", "POST", file_path);
            return Encoding.UTF8.GetString(result, 0, result.Length);
        }

        /*Сохранение новой ссылки магазина*/
        //succses - сохранил
        //fail - ошибка
        //user_login - логин юзера 
        //user_data - ссылка магазина 
        public string setNLink(string user_login, string user_data)
        {
            string request_data = "metreq=" + EncrypteStr("edtl") + "&usrlogin=" + EncrypteStr(user_login) + "&usrshpl=" + EncrypteStr(user_data);
            string requst_ans = connectAPI.RequestPOST("app_lib/user_edit_form.php", request_data);
            return DecrypteStr(requst_ans);
        }

        /*Сохранение нового телефона по логину*/
        //succses - сохранил
        //fail - ошибка
        //user_login - логин юзера 
        //user_data - телефон пользователя
        public string setNPhone(string user_login, string user_data)
        {
            string request_data = "metreq=" + EncrypteStr("edtp") + "&usrlogin=" + EncrypteStr(user_login) + "&usrphn=" + EncrypteStr(user_data);
            string requst_ans = connectAPI.RequestPOST("app_lib/user_edit_form.php", request_data);
            return DecrypteStr(requst_ans);
        }

        /*Сохранение новой почты по логину*/
        //succses - сохранил
        //fail - ошибка
        //user_login - логин юзера 
        //user_data - почта пользователя
        public string setNEmail(string user_login, string user_data)
        {
            string request_data = "metreq=" + EncrypteStr("edte") + "&usrlogin=" + EncrypteStr(user_login) + "&usremail=" + EncrypteStr(user_data);
            string requst_ans = connectAPI.RequestPOST("app_lib/user_edit_form.php", request_data);
            return DecrypteStr(requst_ans);
        }

        /*Сохранение нового пароля по почте*/
        //succses - сохранил
        //fail - ошибка
        //user_email - почта юзера 
        //user_data - пароль пользователя
        public string setNPassE(string user_email, string user_pass)
        {
            string request_data = "metreq=" + EncrypteStr("mspe") + "&usremail=" + EncrypteStr(user_email) + "&usrpass=" + EncrypteStr(connectAPI.generateMD5(user_pass));
            string requst_ans = connectAPI.RequestPOST("app_lib/register_form.php", request_data);
            return DecrypteStr(requst_ans);
        }

        /*Сохранение нового пароля по логину*/
        //succses - сохранил
        //fail - ошибка
        //user_login - логин юзера 
        //user_data - пароль пользователя
        public string setNPassL(string user_login, string user_pass)
        {
            string request_data = "metreq=" + EncrypteStr("mspl") + "&usrlogin=" + EncrypteStr(user_login) + "&usrpass=" + EncrypteStr(connectAPI.generateMD5(user_pass));
            string requst_ans = connectAPI.RequestPOST("app_lib/register_form.php", request_data);
            return DecrypteStr(requst_ans);
        }

        /*Проверка есть ли Email в БД*/
        //found - найден
        //not_found - не найден
        //user_email - почта юзера которого проверяем
        public string checkEMail(string user_mail)
        {
            string request_data = "metreq=" + EncrypteStr("mche") + "&usremail=" + EncrypteStr(user_mail);
            string requst_ans = connectAPI.RequestPOST("app_lib/register_form.php", request_data);
            return DecrypteStr(requst_ans);
        }

        /*Проверка есть ли логин в БД*/
        //found - найден
        //not_found - не найден
        //user_log - логин юзера которого проверяем
        public string checkLogin(string user_log)
        {
            string request_data = "metreq=" + EncrypteStr("mchl") + "&usrlogin=" + EncrypteStr(user_log);
            string requst_ans = connectAPI.RequestPOST("app_lib/register_form.php", request_data);
            return DecrypteStr(requst_ans);
        }

        /*Берем инфорацию магазина*/
        //shop_id - айди магазина
        //shop_fail - магазин не найден
        //shopid:bottoken:chatid:imagelink:anykey:any_id:cardkey:card_id:freekey:fk_id - idмагазинавнашейсистеме:токентгбота:телеграмайди:ключanypay:idanypay:ключcardlink:idcardlink:ключfrekassa:idfreekassa:
        public string getShopInfo(string shop_id)
        {
            string request_data = "metreq=" + EncrypteStr("geti") + "&usrshid=" + EncrypteStr(shop_id);
            string requst_ans = connectAPI.RequestPOST("app_lib/login_form.php", request_data);
            return DecrypteStr(requst_ans);
        }

        /*Регистрация пользователя*/
        //login_full - логин занят
        //email_full - почта занята
        //succses - регистрация успешна
        //fail - ошибка регистрации
        //user_login - логин пользователя
        //user_pass - пароль пользователя
        //user_email - почта юзера
        //user_phone - телефон юзера
        //user_name - имя юзера
        //user_site - ссылка на сайт
        public string registerUser(string user_login, string user_pass, string user_email, string user_phone, string user_name, string user_site)
        {
            string request_data = "metreq=" + EncrypteStr("mreg") + "&usrlogin=" + EncrypteStr(user_login) + "&usrpass=" + EncrypteStr(connectAPI.generateMD5(user_pass)) + "&usremail=" + EncrypteStr(user_email)
                + "&usrphn=" + EncrypteStr(user_phone) + "&usrname=" + EncrypteStr(user_name) + "&usrsurl=" + EncrypteStr(user_site) + "&usrsid=" + EncrypteStr(connectAPI.GenerateString(8, 7));
            string requst_ans = connectAPI.RequestPOST("app_lib/register_form.php", request_data);
            return DecrypteStr(requst_ans);
        }

        /*Вход по почте и логину*/
        //Ответы сервера:
        //pass_fail - пароль не верный
        //login_fail - логин не найден
        //email_fail - почта не найдена
        //method_fail - ошибка запроса метода
        //id:login:phone:name:shoplink:shopid
        //user_email - почта пользователя
        //user_pass - пароль пользователя
        public string checkUserEmail(string user_email, string user_pass, bool isAlreadySaved = true)
        {
            string request_data = "metreq=" + EncrypteStr("loge") + "&usremail=" + EncrypteStr(user_email) + "&usrpass=" + (isAlreadySaved ? EncrypteStr(connectAPI.generateMD5(user_pass)) : EncrypteStr(user_pass));
            string requst_ans = connectAPI.RequestPOST("app_lib/login_form.php", request_data);
            return DecrypteStr(requst_ans);
        }
        //id:email:phone:name:shoplink:shopid
        //user_login - логин пользователя
        //user_pass - пароль пользователя
        public string checkUserLogin(string user_login, string user_pass, bool isAlreadySaved = true)
        {
            string request_data = "metreq=" + EncrypteStr("logl") + "&usrlogin=" + EncrypteStr(user_login) + "&usrpass=" + (isAlreadySaved ? EncrypteStr(connectAPI.generateMD5(user_pass)) : EncrypteStr(user_pass));
            string requst_ans = connectAPI.RequestPOST("app_lib/login_form.php", request_data);
            return DecrypteStr(requst_ans);
        }
    }
}
