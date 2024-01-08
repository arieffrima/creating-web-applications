<!DOCTYPE html> 
<html lang="en">
<?php include('header.inc'); ?>
<?php include('settings.php'); ?>
<title>Apply</title>
<script src="scripts/apply.js"></script>
  <script src="scripts/enhancements.js"></script>
  <link href="styles/style.css" rel="stylesheet"/>
<body>
<?php include('menu.inc'); ?>
  <article>
<Fieldset>
<form id="applynow" method="post" action="processEOI.php" novalidate="novalidate">
    
      <p>
        <label for="JRN">Job Reference Number</label>
        <input type="text" 
        name= "JRN"
        id="JRN" 
       readonly>
      </p>	
      <p>
        <label for="firstname">First Name</label>
        <input type="text" 
        name="firstname" 
        id="firstname"
        pattern="[a-zA-Z]{1,20}+$" 
        maxlength="20" required>
       
      </p>
      <p>
        <label for="lastname">Last Name</label>
        <input type="text" 
        name= "lastname" 
        id="lastname" 
        pattern="[a-zA-Z]{1,20}+$" 
        maxlength="20" required>
      </p>
  
      <p>
        <label for="DOB">Date of birth</label>
        <input type="date" 
        id="DOB"
        name="DOB"
       required="required"/>
      </p>
  
<fieldset>
    <legend>Gender</legend>
      <p>
        <label> <input type="radio" name="gender" value="male" checked="checked"/>Male</label> 
        <label> <input type="radio" name="gender" value="female" checked="checked"/>Female</label>
      </p>
</fieldset>
      <p>
        <label for="streetaddress">Street Address</label>
        <input type="text" 
        name= "streetaddress" 
        id="streetaddress"
        required="required" /> 
      </p>
  
      <p>
        <label for="suburb/town">Suburb/Town</label>
        <input type="text" 
        name= "suburb/town" 
        id="suburb/town"
        required="required"/>
      </p>

      <p> State <select name="state" id="state">
          <option value="PleaseSelect">Plese Select</option>			
          <option value="VIC">VIC</option>
          <option value="NSW">NSW</option>
          <option value="QLD">QLD</option>
          <option value="NT">NT</option>
          <option value="WA">WA</option>
          <option value="SA">SA</option>
          <option value="TAS">TAS</option>
          <option value="ACT">ACT</option>
        </select>
      </p>
      
      <p>
          <label for="postcode">Postcode</label>
          <input type="text"
          name= "postcode" 
          id="postcode"
          pattern="\d{4}" 
          required="required" />
      </p>
  
      <p>
          <label for="email">Email Address</label>
          <input type="email" 
          name= "email" 
          id="email"
          placeholder="104196233@student.swin.edu.au"
          required="required"/>
      </p>
        
      <p>
          <label for="phonenumber">Phone Number</label>
          <input type="tel" 
          name= "phonenumber" 
          id="phonenumber" 
          pattern="^[0-9]{8,12}$" 
          required="required" />
      </p>
  
      <p> Apply for 
        <select name="applyfor" id="applyfor">
          <option value="PleaseSelect">Plese Select</option>			
          <option value="cybersecurity">Cyber Security</option>
          <option value="database">Database Administrator</option>
        </select>
      </p>
  
      <p>Skill : 
          <input type="checkbox" id="python" 
          name="category[]" value="python"/>
          <label for="python">Python</label> 
          
          <input type="checkbox" id="devops" 
                 name="category[]" value="devops"/>
          <label for="devops">DevOps</label>
  
          <input type="checkbox" id="SQL" 
                  name="category[]" value="SQL"/>
          <label for="SQL">SQL</label>
  
          <input type="checkbox" id="powershell" 
                  name="category[]" value="powershell"/>
          <label for="powershell">Power Shell</label>
  
          <input type="checkbox" id="powerbi" 
                  name="category[]" value="powerbi"/>
          <label for="powerbi">Power BI</label>
  
          <input type="checkbox" id="oracle" 
                  name="category[]" value="oracle"/>
          <label for="oracle">Oracle DBA</label>
  
          <input type="checkbox" id="other" 
                  name="category[]" value="other"/>
          <label for="other">Other Skills..</label>
        </p>
     
        <p>
          <label>Other Skills</label><br/>
          <textarea id="comments" name="comments" rows="4" cols="40"></textarea>
        </p>

        <p>
          <label id="applicationDate">Application Date</label>
          <select id="day" name="day"></select>
          <select id="month" name="month"></select>
          <select id="year" name="year"></select>
        </p>
        <p>
          <input type="submit" value="Apply"/>
  </form>
          <div id="timer-container">
            <p>Time remaining: <span id="timer" style="color: rgb(41, 135, 120);">30:00</span></p>
            <p id="timer-warning" style="color: red;"></p>
          </div>
          <div id="error-messages" style="color: red;"></div>
 
  </Fieldset>
  <?php include('footer.inc'); ?>
</body>
</html>