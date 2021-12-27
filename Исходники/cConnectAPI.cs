using System;
using System.IO;
using System.Net;
using System.Net.Mail;
using System.Security.Cryptography;
using System.Text;
using System.Windows;

namespace ServerLibrary
{
    public class cConnectAPI
    {
        public string host_link = "https://npanel.ru/CourseWork/";

        //Проверяем работает ли хост
        public bool CheckServerOnline()
        {
            try
            {
                HttpWebRequest reqFP = (HttpWebRequest)HttpWebRequest.Create(host_link);
                HttpWebResponse rspFP = (HttpWebResponse)reqFP.GetResponse();
                if (HttpStatusCode.OK == rspFP.StatusCode)
                {
                    rspFP.Close();
                    return true;
                }
                else
                {
                    rspFP.Close();
                    return false;
                }
            }
            catch (WebException)
            {
                return false;
            }
        }

        //Запрос POST
        public string RequestPOST(string file_link, string data)
        {
            WebRequest req = WebRequest.Create(host_link + file_link);
            req.Method = "POST";
            req.Timeout = 100000;
            req.ContentType = "application/x-www-form-urlencoded";
            byte[] sentData = Encoding.ASCII.GetBytes(data);
            req.ContentLength = sentData.Length;
            Stream sendStream = req.GetRequestStream();
            sendStream.Write(sentData, 0, sentData.Length);
            sendStream.Close();
            WebResponse res = req.GetResponse();
            Stream ReceiveStream = res.GetResponseStream();
            StreamReader sr = new System.IO.StreamReader(ReceiveStream, Encoding.UTF8);
            Char[] read = new Char[256];
            int count = sr.Read(read, 0, 256);
            string Out = String.Empty;
            while (count > 0)
            {
                String str = new String(read, 0, count);
                Out += str;
                count = sr.Read(read, 0, 256);
            }
            return Out;
        }

        public string EncryptString(string plainText, byte[] key, byte[] iv)
        {
            // Создаем экземпляр нового объекта Aes для выполнения симметричного шифрования строк
            Aes encryptor = Aes.Create();

            encryptor.Mode = CipherMode.CBC;
            //encryptor.KeySize = 256;
            //encryptor.BlockSize = 128;
            //encryptor.Padding = PaddingMode.Zeros;

            // Сохраняем ключ и байты
            encryptor.Key = key;
            encryptor.IV = iv;

            //Создаем новый объект MemoryStream, содержащий зашифрованные байты
            MemoryStream memoryStream = new MemoryStream();

            // Создаем экземпляр нового шифратора из нашего объекта Aes
            ICryptoTransform aesEncryptor = encryptor.CreateEncryptor();

            // Создание экземпляра нового объекта CryptoStream для обработки данных и записи их в
            CryptoStream cryptoStream = new CryptoStream(memoryStream, aesEncryptor, CryptoStreamMode.Write);

            // Конверт текста в байты
            byte[] plainBytes = Encoding.ASCII.GetBytes(plainText);

            // Криптование текста и запись
            cryptoStream.Write(plainBytes, 0, plainBytes.Length);

            // Конец криптования
            cryptoStream.FlushFinalBlock();

            // Cпереносим в байты крипованный текст
            byte[] cipherBytes = memoryStream.ToArray();

            // Закрываем потоки
            memoryStream.Close();
            cryptoStream.Close();

            // Конверс криптованного текста в бейс4
            string cipherText = Convert.ToBase64String(cipherBytes, 0, cipherBytes.Length);

             return cipherText;
        }

        public string DecryptString(string cipherText, byte[] key, byte[] iv)
        {
            // Создаем экземпляр нового объекта Aes для выполнения симметричного шифрования строк
            Aes encryptor = Aes.Create();

            encryptor.Mode = CipherMode.CBC;
            //encryptor.KeySize = 256;
            //encryptor.BlockSize = 128;
            //encryptor.Padding = PaddingMode.Zeros;

            // Сохраняем ключ и байты
            encryptor.Key = key;
            encryptor.IV = iv;

            //Создаем новый объект MemoryStream, содержащий зашифрованные байты
            MemoryStream memoryStream = new MemoryStream();

            // Создаем экземпляр нового шифратора из нашего объекта Aes
            ICryptoTransform aesDecryptor = encryptor.CreateDecryptor();

            // Создание экземпляра нового объекта CryptoStream для обработки данных и записи их в
            CryptoStream cryptoStream = new CryptoStream(memoryStream, aesDecryptor, CryptoStreamMode.Write);

            // Будет содержать расшифрованный открытый текст
            string plainText = String.Empty;

            try
            {
                // Переводим в байты криптованный текст
                byte[] cipherBytes = Convert.FromBase64String(cipherText);

                // Декрипт и запись текста
                cryptoStream.Write(cipherBytes, 0, cipherBytes.Length);

                // заканчиваем процесс
                cryptoStream.FlushFinalBlock();

                // переводим в байты
                byte[] plainBytes = memoryStream.ToArray();

                // Байты в текст
                plainText = Encoding.ASCII.GetString(plainBytes, 0, plainBytes.Length);
            }
            finally
            {
                memoryStream.Close();
                cryptoStream.Close();
            }

            return plainText;
        }

        public string generateMD5(string passValue)
        {
            MD5 md5 = MD5.Create();
            byte[] inputBytes = Encoding.ASCII.GetBytes(passValue);
            byte[] hash = md5.ComputeHash(inputBytes);
            StringBuilder sb = new StringBuilder();
            for (int i = 0; i < hash.Length; i++)
            {
                sb.Append(hash[i].ToString("X2"));
            }
            return sb.ToString();
        }

        public string GenerateString(int letters, int numbers)
        {
            Random rnd = new Random();
            StringBuilder sb = new StringBuilder(letters + numbers);
            string letterSet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            string numberSet = "0123456789";
            for (int i = 0; i < letters; i++)
                sb.Append(letterSet[rnd.Next(letterSet.Length)]);
            for (int i = 0; i < numbers; i++)
                sb.Append(numberSet[rnd.Next(numberSet.Length)]);
            return sb.ToString();
        }
    }
}
