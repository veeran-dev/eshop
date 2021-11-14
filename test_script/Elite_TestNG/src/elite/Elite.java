package elite;

import org.testng.annotations.BeforeTest;
import org.testng.annotations.Test;
import org.openqa.selenium.*;
import org.openqa.selenium.firefox.*;
import org.openqa.selenium.chrome.ChromeDriver;


public class Elite {
	
	public WebDriver driver;
	String url = "http://localhost/kobsterEshop/dash-login.php";
	
	
	@BeforeTest
	public void openbrowswer(){
		
		driver = new FirefoxDriver();
		driver.get(url);
	}
	
	@Test
	public void a_login() {
		
		driver.manage().window().maximize();
		driver.findElement(By.id("login_email")).sendKeys("scn@kobster.com");
		driver.findElement(By.id("login_passwd")).sendKeys("kobster123");
		driver.findElement(By.id("SubmitDashLogin")).click();
			
		
	}
	
	@Test
	public void b_purchaselist() throws InterruptedException{
		
		 driver.findElement(By.xpath("//div/div[1]/div[1]/div[1]/div/div[2]/div[1]")).click();
         Thread.sleep(3000);
         driver.findElement(By.xpath("//section/div/div/div/section/div/div/div[2]/section[1]/div[1]/div[1]/section/div/button")).click();
         Thread.sleep(3000);
         driver.findElement(By.xpath("//div/div/div/section/div/div/div[2]/section[1]/div[1]/div[1]/section/div/ul/li[2]/a")).click();
         Thread.sleep(3000);
         driver.findElement(By.xpath("//div/section/div/div/div[2]/section[1]/div[1]/div[2]/div/div/section[1]/div[1]/div[1]/table/tbody/tr[1]/td[4]/input")).sendKeys("2");
         Thread.sleep(3000);
         driver.findElement(By.xpath("//div/div/section/div/div/div[2]/section[1]/div[1]/div[2]/div/div/section[1]/div[3]/div/input")).click();
         Thread.sleep(3000);
         driver.findElement(By.xpath("//div/div[1]/div[2]/section/div[3]/input")).click();
         Thread.sleep(3000);
         driver.findElement(By.xpath("//section/section/div/div/div/section/div/div/div[2]/section[2]/div/div[1]/div[2]/section/div/div/form/div/div[4]")).click();
         Thread.sleep(3000);
         driver.findElement(By.xpath("//div/div/div[2]/section[3]/div[2]/div[2]/section/div/div/div[1]/div[2]/a/img")).click();
         Thread.sleep(4000);
         driver.findElement(By.xpath("//section/section/section/div/section/div/div[2]/a")).click();
         Thread.sleep(3000);
	}
	
	@Test
	public void c_quickbuy() throws InterruptedException{
		
		 Thread.sleep(2000);
         driver.findElement(By.xpath("//section/div/div[1]/div[1]/div[2]/div/div[2]/div[1]")).click();
         Thread.sleep(2000);
         driver.findElement(By.xpath("//div/section/div/div/div[2]/section[1]/div/div[1]/div[1]/input")).sendKeys("Classmate");
         Thread.sleep(2000);
         driver.findElement(By.xpath("/html/body/div[27]/ul/li/div/span[2]")).click();
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
         Thread.sleep(4000);
         driver.findElement(By.xpath("//section/section/div/section/div/div[2]/a")).click();
         Thread.sleep(2000);
	}
	
	@Test
	public void d_reorder() throws InterruptedException{
		
		driver.findElement(By.xpath("//section/div/div[1]/div[1]/div[3]/div/div[2]/div[1]")).click();
		Thread.sleep(3000);
		driver.findElement(By.xpath("//div/div/div/section/div[1]/div/table/tbody/tr[1]/td[9]/span")).click();
		Thread.sleep(3000);
		driver.findElement(By.xpath("//div/div[1]/div[2]/section/div[3]/input")).click();
        Thread.sleep(2000);
        driver.findElement(By.xpath("//div/section/div/div/div[2]/section[2]/div/div[1]/div[3]/section/div/div/form/div/div[4]/textarea")).click();
        Thread.sleep(2000);
        driver.findElement(By.xpath("//div/div/div[2]/section[3]/div[2]/div[2]/section/div/div/div[1]/div[2]/a/img")).click();
        Thread.sleep(4000);
        driver.findElement(By.xpath("//section/section/div/section/div/div[2]/a")).click();
        Thread.sleep(2000);
		
	}
	
}
