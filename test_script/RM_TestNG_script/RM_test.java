package rm_portal;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.testng.annotations.BeforeTest;
import org.testng.annotations.Test;

public class RM_test {
	
	public WebDriver driver;
	String url = "http://localhost/kobsterEshop/rm-login.php";
	
	
	@BeforeTest
	public void openbrowswer(){
		
		driver = new FirefoxDriver();
		driver.get(url);
	}
	
	@Test
	public void a_login() {
		
		driver.manage().window().maximize();
		driver.findElement(By.id("RM_email")).sendKeys("scn@kobster.com");
		driver.findElement(By.id("RM_passwd")).sendKeys("kobster123");
		driver.findElement(By.id("SubmitRMLogin")).click();
				
	}
	
	@Test
	public void b_placeorder() throws InterruptedException{
		
		Thread.sleep(3000);
		driver.findElement(By.xpath("//section/aside/div/div[1]/ul/li[2]/a/span")).click();
		Thread.sleep(3000);
		driver.findElement(By.xpath("//section/section/div/div/div/div/button")).click();
		Thread.sleep(3000);
		driver.findElement(By.xpath("//section/section/div/div/div/div/ul/li[1]/a")).click();
		Thread.sleep(3000);
		driver.findElement(By.xpath("//section/div/div[2]/div/section/div/div/div[2]/section[1]/div[1]/div/div[1]/div[3]/span[1]/a[2]")).click();
		Thread.sleep(2000);
		driver.findElement(By.id("focusedInput")).sendKeys("Belkin");
		Thread.sleep(2000);
		driver.findElement(By.id("search_image")).click();
		Thread.sleep(3000);
		driver.findElement(By.xpath("//section/div/div[2]/div/section/div/div/div[2]/section[1]/div[1]/div/div[2]/input")).sendKeys("1");
		Thread.sleep(3000);
		driver.findElement(By.xpath("//section/div/div[2]/div/section/div/div/div[2]/section[1]/div[1]/div/div[3]/a")).click();
		Thread.sleep(3000);
		driver.findElement(By.xpath("//section/div/div[2]/div/section/div/div/div[2]/section[1]/div[1]/div/div[1]/div[3]/span[1]/a[1]")).click();
		Thread.sleep(3000);
		driver.findElement(By.id("focusedInput")).sendKeys("Classmate");
		Thread.sleep(2000);
		driver.findElement(By.xpath("/html/body/div[10]/ul/li/div/span[1]/img")).click();
		Thread.sleep(3000);
		driver.findElement(By.xpath("//section/div/div[2]/div/section/div/div/div[2]/section[1]/div[1]/div/div[2]/input")).sendKeys("1");
		Thread.sleep(3000);
		driver.findElement(By.xpath("//section/div/div[2]/div/section/div/div/div[2]/section[1]/div[1]/div/div[3]/a")).click();
		Thread.sleep(3000);
		driver.findElement(By.id("next_button")).click();
		Thread.sleep(3000);
		driver.findElement(By.id("address38")).click();
		Thread.sleep(3000);
		driver.findElement(By.xpath("//section/div/div[2]/div/section/div/div/div[2]/section[3]/div[2]/div[2]/section/div/div/div[1]/div[2]/a/img")).click();
		Thread.sleep(4000);
		driver.findElement(By.xpath("//section/section/section/div/section/div/div[2]/a")).click();
		Thread.sleep(3000);
	}

}
