CREATE TABLE student_health_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    -- Student Information
    FullName VARCHAR(255),
    StudentID VARCHAR(50) UNIQUE,
    Age INT(3),
    DOB DATE,
    BloodType VARCHAR(10),
    YearLevel VARCHAR(50),
    Program VARCHAR(50),
    ParentGuardian VARCHAR(255),
    ParentContacts VARCHAR(20), -- Backticks required because of the '#' symbol
    
    -- History Textareas
    ChildhoodDisease TEXT,
    SurgicalOperations TEXT,
    InjuriesIllness TEXT,
    KnownAllergies TEXT,
    ExistingMedicalCondition TEXT,
    CurrentMedications TEXT,
    LastMedicalCheckUp DATE,

    -- Immunization (Radio Buttons)
    Immunization ENUM('Yes', 'No') DEFAULT 'No',
    BCG ENUM('Yes', 'No') DEFAULT 'No',
    OralPolio ENUM('Yes', 'No') DEFAULT 'No',
    DPT ENUM('Yes', 'No') DEFAULT 'No',
    HepaA ENUM('Yes', 'No') DEFAULT 'No',
    HepaB ENUM('Yes', 'No') DEFAULT 'No',
    
    -- Covid-19 Vaccines
    Covid1stDose DATE,
    Covid2ndDose DATE,
    CovidBooster DATE,

    -- Family History Checkboxes (Prefixed with Family_ as per your code)
    Family_HeartDisease ENUM('Yes', 'No') DEFAULT 'No',
    Family_Tuberculosis ENUM('Yes', 'No') DEFAULT 'No',
    Family_Diabetes ENUM('Yes', 'No') DEFAULT 'No',
    Family_Cancer ENUM('Yes', 'No') DEFAULT 'No',
    Family_Allergy ENUM('Yes', 'No') DEFAULT 'No',

    -- Health Checklist (Checkboxes)
    HeadHeadache ENUM('Yes', 'No') DEFAULT 'No',
    HeadInjury ENUM('Yes', 'No') DEFAULT 'No',
    EyeGlasses ENUM('Yes', 'No') DEFAULT 'No',
    EyeContacts ENUM('Yes', 'No') DEFAULT 'No',
    EyeTrouble ENUM('Yes', 'No') DEFAULT 'No',
    Ulcer ENUM('Yes', 'No') DEFAULT 'No',
    Gallbladder ENUM('Yes', 'No') DEFAULT 'No',
    Jaundices ENUM('Yes', 'No') DEFAULT 'No',
    TumorGrowthCystCancer ENUM('Yes', 'No') DEFAULT 'No',
    AbdominalPain ENUM('Yes', 'No') DEFAULT 'No',
    ConvulsionEpilepsy ENUM('Yes', 'No') DEFAULT 'No',
    Difficultytosleep ENUM('Yes', 'No') DEFAULT 'No',
    PsychiatricTreatment ENUM('Yes', 'No') DEFAULT 'No',
    Concentration ENUM('Yes', 'No') DEFAULT 'No',
    LossofMemory ENUM('Yes', 'No') DEFAULT 'No',
    Excessivesleepiness ENUM('Yes', 'No') DEFAULT 'No',
    HistExercise ENUM('Yes', 'No') DEFAULT 'No',
    HistSmoking ENUM('Yes', 'No') DEFAULT 'No',
    HistAlcohol ENUM('Yes', 'No') DEFAULT 'No',
    HistDrugs ENUM('Yes', 'No') DEFAULT 'No',
    EarHearing ENUM('Yes', 'No') DEFAULT 'No',
    EarAid ENUM('Yes', 'No') DEFAULT 'No',
    EarEardrum ENUM('Yes', 'No') DEFAULT 'No',
    EarCleft ENUM('Yes', 'No') DEFAULT 'No',
    EarSpeech ENUM('Yes', 'No') DEFAULT 'No',
    NeckMass ENUM('Yes', 'No') DEFAULT 'No',
    Tuberculosis ENUM('Yes', 'No') DEFAULT 'No',
    Asthma ENUM('Yes', 'No') DEFAULT 'No',
    ShortnessofBreath ENUM('Yes', 'No') DEFAULT 'No',
    PainChest ENUM('Yes', 'No') DEFAULT 'No',
    Palpitation ENUM('Yes', 'No') DEFAULT 'No',
    HeartTrouble ENUM('Yes', 'No') DEFAULT 'No',
    HighBloodPress ENUM('Yes', 'No') DEFAULT 'No',
    WornNeckBackBraceSupport ENUM('Yes', 'No') DEFAULT 'No',
    BoneJointDisabilityDeformity ENUM('Yes', 'No') DEFAULT 'No',
    LossArmLegfingertoe ENUM('Yes', 'No') DEFAULT 'No',
    FootTrouble ENUM('Yes', 'No') DEFAULT 'No',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- 1. Create the Table
CREATE TABLE IF NOT EXISTS announcements (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    category VARCHAR(50) DEFAULT 'General',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Add a starting announcement so the page isn't empty
INSERT INTO announcements (title, content, category) 
VALUES ('Welcome to Campus Care', 'The health portal is now active for all APCAS students.', 'System');