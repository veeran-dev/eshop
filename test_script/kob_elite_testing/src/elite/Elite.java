package elite;

import org.openqa.selenium.*;
import org.openqa.selenium.chrome.*;


public class Elite {
	
	public static void main(String[] args) throws InterruptedException{
		
		  System.setProperty("webdriver.chrome.driver", "C:/Program Files/ChromeDriver(selenium jar files)/chromedriver.exe");
          WebDriver driver=new ChromeDriver(); 
          driver.get("http://kobster.com/dash-login.php");
          driver.manage().window().maximize();
          Thread.sleep(3000);
          driver.findElement(By.id("login_email")).sendKeys("arunraj.m@kobster.com");
          driver.findElement(By.id("login_passwd")).sendKeys("testing123");
          driver.findElement(By.id("SubmitDashLogin")).click();
          Thread.sleep(2000);
          
          /******** PURCHASE LIST *******/
          driver.findElement(By.xpath("//div/div[1]/div[1]/div[1]/div/div[2]/div[1]")).click();
          Thread.sleep(3000);
          driver.findElement(By.xpath("//section/div/div/div/section/div/div/div[2]/section[1]/div[1]/div[1]/section/div/button")).click();
          Thread.sleep(2000);
          driver.findElement(By.xpath("//div/div/div/section/div/div/div[2]/section[1]/div[1]/div[1]/section/div/ul/li[2]/a")).click();
          Thread.sleep(2000);
          driver.findElement(By.xpath("//div/section/div/div/div[2]/section[1]/div[1]/div[2]/div/div/section[1]/div[1]/div[1]/table/tbody/tr[1]/td[4]/input")).sendKeys("2");
          Thread.sleep(2000);
          driver.findElement(By.xpath("//section/div/div/div/section/div/div/div[2]/section[1]/div[1]/div[2]/div/div/section[1]/div[1]/div[1]/table/tbody/tr[5]/td[4]/input")).sendKeys("3");
          Thread.sleep(2000);
          driver.findElement(By.xpath("//div/div/section/div/div/div[2]/section[1]/div[1]/div[2]/div/div/section[1]/div[3]/div/input")).click();
          Thread.sleep(2000);
          driver.findElement(By.xpath("//div/div[1]/div[2]/section/div[3]/input")).click();
          Thread.sleep(2000);
          driver.findElement(By.xpath("//div/section/div/div/div[2]/section[2]/div/div[1]/div[3]/section/div/div/form/div/div[4]/textarea")).click();
          Thread.sleep(2000);
          driver.findElement(By.xpath("//div/div/div[2]/section[3]/div[2]/div[2]/section/div/div/div[1]/div[2]/a/img")).click();
          Thread.sleep(2000);
          driver.findElement(By.xpath("//section/section/div/section/div/div[2]/a")).click();
          Thread.sleep(2000);
         
          
          /*************QUICK BUY*****************/
          Thread.sleep(2000);
          driver.findElement(By.xpath("//section/div/div[1]/div[1]/div[2]/div/div[2]/div[1]")).click();
          Thread.sleep(2000);
          driver.findElement(By.xpath("//div/section/div/div/div[2]/section[1]/div/div[1]/div[1]/input")).sendKeys("Classmate");
          Thread.sleep(2000);
          driver.findElement(By.xpath("/html/body/div[25]/ul/li[1]/div/span[2]")).click();
          Thread.sleep(2000);
          driver.findElement(By.xpath("//section/div/div/div[2]/section[1]/div/div[1]/div[2]/input")).sendKeys("0");
          Thread.sleep(2000);
          driver.findElement(By.xpath("//div/div/div/section/div/div/div[2]/section[1]/div/div[1]/div[3]/a")).click();
          Thread.sleep(2000);
          driver.findElement(By.xpath("//div/div[1]/div[2]/section/div[3]/input")).click();
          Thread.sleep(2000);
          driver.findElement(By.xpath("//div/section/div/div/div[2]/section[2]/div/div[1]/div[3]/section/div/div/form/div/div[4]/textarea")).click();
          Thread.sleep(2000);
          driver.findElement(By.xpath("//div/div/div[2]/section[3]/div[2]/div[2]/section/div/div/div[1]/div[2]/a/img")).click();
          Thread.sleep(2000);
          driver.findElement(By.xpath("//section/section/div/section/div/div[2]/a")).click();
          Thread.sleep(2000);
          
       	}

}
