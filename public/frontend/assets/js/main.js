// eDegree+ Database and Shared Functionality
const eDegreeDb = window.eDegreeDbData || {
  universities: [
    {
      id: "ggu-usa",
      name: "Golden Gate University",
      shortName: "GGU",
      location: "San Francisco, USA",
      founded: 1901,
      accreditation: "WASC Senior College and University Commission (WSCUC)",
      logo: `<svg class="w-12 h-12 text-brand-red" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" /></svg>`,
      logoUrl: "https://images.unsplash.com/photo-1592280771190-3e2e4d571952?w=120&h=120&fit=crop&q=80",
      banner: "https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1600&h=600&fit=crop&q=80",
      description: "Golden Gate University is a private, non-profit university in San Francisco, California. Founded in 1901, GGU specializes in educating professionals through its schools of law, business, taxation, and accounting. GGU's online programs are designed specifically for working adults, offering rigorous academic standards, flexible pacing, and access to a massive global alumni network in Silicon Valley and beyond.",
      programsCount: 4,
      ranking: "#38 in Best Regional Universities West (US News)",
      stats: [
        { label: "Founded", value: "1901" },
        { label: "Alumni Network", value: "68,000+" },
        { label: "Accreditation", value: "WSCUC" },
        { label: "Study Mode", value: "100% Online" }
      ],
      admissions: "Admissions at Golden Gate University are open to professionals holding a valid Bachelor's degree (for postgraduate courses) or a High School Diploma (for undergraduate programs). Standardized test scores (GMAT/GRE) are optional. Applicants must submit official academic transcripts, a professional resume, and a statement of purpose. English language proficiency (TOEFL, IELTS, or Duolingo) is required for international applicants.",
      reviews: [
        { author: "Marcus Vance, MBA Graduate", rating: 5, text: "GGU's online MBA was incredibly practical. Every project I completed could be directly applied to my tech-consulting career." },
        { author: "Dr. Sarah Chen, DBA Alum", rating: 5, text: "The DBA program provided the ideal balance between structured doctoral research and flexible online coursework. The faculty feedback was top-notch." }
      ]
    },
    {
      id: "london-met",
      name: "London Metropolitan University",
      shortName: "London Met",
      location: "London, United Kingdom",
      founded: 1848,
      accreditation: "QAA (Quality Assurance Agency for Higher Education, UK)",
      logo: `<svg class="w-12 h-12 text-brand-red" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-.778.099-1.533.284-2.253" /></svg>`,
      logoUrl: "https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=120&h=120&fit=crop&q=80",
      banner: "https://images.unsplash.com/photo-1513694203232-719a280e022f?w=1600&h=600&fit=crop&q=80",
      description: "London Metropolitan University is an established public university in London, England. With roots dating back to 1848, it is renowned for its diverse student body and practical, career-focused education. By partnering with leading online facilitators, London Met offers globally recognized degrees that carry full UK university status, allowing learners worldwide to upgrade their credentials without relocating to the UK.",
      programsCount: 3,
      ranking: "Top 100 UK University (The Guardian University Guide)",
      stats: [
        { label: "Founded", value: "1848" },
        { label: "UK Ranking", value: "Top 100" },
        { label: "Accreditation", value: "QAA Approved" },
        { label: "Degrees", value: "UK Accredited" }
      ],
      admissions: "Applicants must hold a UK Bachelor's degree (Honours 2:2 or above) or an equivalent international qualification. Professional experience may be considered for mature candidates who lack formal academic credentials. Standard application requirements include letters of recommendation, academic transcripts, and evidence of English proficiency (IELTS 6.0 minimum or equivalent).",
      reviews: [
        { author: "David K., Global MBA Student", rating: 4.8, text: "Having a UK degree on my profile has opened doors in Europe. The online portal is clean and easy to navigate." },
        { author: "Elena R., MSc Data Science Student", rating: 5, text: "The curriculum matches the on-campus program exactly. Exams are proctored online and group work is highly collaborative." }
      ]
    },
    {
      id: "iu-germany",
      name: "IU International University of Applied Sciences",
      shortName: "IU Germany",
      location: "Erfurt, Germany",
      founded: 1998,
      accreditation: "FIBAA (Foundation for International Business Administration Accreditation) & German Accreditation Council",
      logo: `<svg class="w-12 h-12 text-brand-red" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.62 48.62 0 0112 20.904a48.62 48.62 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 019.218 5.84 50.57 50.57 0 00-2.658.814m-15.482 0A50.714 50.714 0 0112 11.25a50.713 50.713 0 017.84-1.103M12 20.055V11.25" /></svg>`,
      logoUrl: "https://images.unsplash.com/photo-1525921429624-479b6c294560?w=120&h=120&fit=crop&q=80",
      banner: "https://images.unsplash.com/photo-1541339907198-e08756dedf3f?w=1600&h=600&fit=crop&q=80",
      description: "IU International University of Applied Sciences is Germany's largest private, state-accredited university. IU offers an innovative approach to online learning, featuring 100% digital study paths with high-quality digital textbooks, online exams 24/7, and AI-supported learning assistance. Over 100,000 students from around the world choose IU to obtain European degree qualification in high-demand business and tech industries.",
      programsCount: 4,
      ranking: "5 Stars for Online Learning (QS Stars)",
      stats: [
        { label: "Founded", value: "1998" },
        { label: "Active Students", value: "100,000+" },
        { label: "Accreditation", value: "FIBAA, Council of Sciences" },
        { label: "Exam Formats", value: "Online 24/7" }
      ],
      admissions: "For Bachelor's degrees: secondary school graduation certificate (Abitur/High School Diploma/A-Levels). For Master's and MBA: a completed undergraduate degree, professional experience, and proof of English proficiency. IU is unique in offering flexible entry deadlines — you can enroll and start your courses at any time of the year.",
      reviews: [
        { author: "Liam S., B.Sc. Computer Science", rating: 4.9, text: "The freedom to take exams whenever I'm ready is amazing. Perfect for combining studies with full-time software engineering work." }
      ]
    },
    {
      id: "chicago-state",
      name: "Chicago State University",
      shortName: "CSU",
      location: "Chicago, USA",
      founded: 1867,
      accreditation: "Higher Learning Commission (HLC)",
      logo: `<svg class="w-12 h-12 text-brand-red" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>`,
      logoUrl: "https://images.unsplash.com/photo-1492538368677-f6e0afe31dcc?w=120&h=120&fit=crop&q=80",
      banner: "https://images.unsplash.com/photo-1562774053-701939374585?w=1600&h=600&fit=crop&q=80",
      description: "Chicago State University is a public university founded in 1867. A cornerstone of higher education in Chicago, CSU provides diverse undergraduate and graduate degree options. Through dynamic online program structures, CSU is making high-quality, regionally-accredited American university degree education accessible to global scholars and working professionals seeking to ascend in corporate administration, healthcare, and engineering systems.",
      programsCount: 2,
      ranking: "Regionally Accredited Public University",
      stats: [
        { label: "Founded", value: "1867" },
        { label: "Accreditation", value: "HLC Accredited" },
        { label: "Type", value: "Public University" },
        { label: "Format", value: "Flexible Online" }
      ],
      admissions: "Admissions require a completed application form, official academic transcripts, and a professional resume. Minimum GPA requirements apply. Letters of recommendation and personal statement are standard for graduate courses. Test scores (GRE/GMAT) may be waived for applicants with relevant industry experience.",
      reviews: [
        { author: "Angela H., MBA Graduate", rating: 4.7, text: "The professors were highly interactive and held live sessions. The program helped me transition to a senior administration role." }
      ]
    },
    {
      id: "shiv-nadar",
      name: "Shiv Nadar University",
      shortName: "Shiv Nadar",
      location: "NCR, India",
      founded: 2011,
      accreditation: "UGC (University Grants Commission, India) & NAAC Grade A",
      logo: `<svg class="w-12 h-12 text-brand-red" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>`,
      logoUrl: "https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?w=120&h=120&fit=crop&q=80",
      banner: "https://images.unsplash.com/photo-1607237138185-eedd996c5c0c?w=1600&h=600&fit=crop&q=80",
      description: "Shiv Nadar University (SNU) is a comprehensive, multidisciplinary, research-focused private university in India. Awarded the status of 'Institution of Eminence' by the Government of India, SNU is dedicated to high-standard research, pioneering curricula, and top placement ties. SNU's online degree portfolio brings premium Indian higher education to global professionals seeking specialization in digital transformations, finance, and advanced business systems.",
      programsCount: 2,
      ranking: "#1 New Private University in India (UGC/NIRF)",
      stats: [
        { label: "Founded", value: "2011" },
        { label: "Status", value: "Institution of Eminence" },
        { label: "Accreditation", value: "NAAC Grade A, UGC" },
        { label: "Tech Partners", value: "Leading Industry Brands" }
      ],
      admissions: "Postgraduate admissions require a recognized Bachelor's degree with minimum 50% score. Candidate selection is based on an academic profile screening, professional accomplishments, statement of purpose, and an online evaluation interview conducted by the SNU business faculty panel.",
      reviews: [
        { author: "Rajesh P., MBA in Digital Finance", rating: 4.8, text: "A truly cutting-edge curriculum focusing on Fintech, blockchain and analytics. Highly relevant for modern finance executives." }
      ]
    },
    {
      id: "ljmu-uk",
      name: "Liverpool John Moores University",
      shortName: "LJMU",
      location: "Liverpool, United Kingdom",
      founded: 1823,
      accreditation: "QAA (Quality Assurance Agency for Higher Education, UK)",
      logo: `<svg class="w-12 h-12 text-brand-red" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582" /></svg>`,
      logoUrl: "https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=120&h=120&fit=crop&q=80",
      banner: "https://images.unsplash.com/photo-1541829019-2592e6274bc2?w=1600&h=600&fit=crop&q=80",
      description: "Liverpool John Moores University is a distinctive public research university in Liverpool, England. Tracing its lineage to 1823, LJMU is now one of the largest and most dynamic universities in the UK. By extending its postgraduate pathways online, LJMU makes advanced degrees in Data Science, Computing, and Global Business Administration accessible to international students wishing to secure prestigious British academic certifications.",
      programsCount: 2,
      ranking: "Top 50 UK University (Times Higher Education)",
      stats: [
        { label: "Founded", value: "1823" },
        { label: "UK Ranking", value: "Top 50" },
        { label: "Accreditation", value: "QAA Approved" },
        { label: "Research", value: "World-Class (REF 2021)" }
      ],
      admissions: "For MSc programs: a completed Bachelor's degree in a quantitative field (Mathematics, Engineering, Computing, or Science) or equivalent experience. Standard applications require transcripts, a curriculum vitae, and English proficiency test details.",
      reviews: [
        { author: "Ksenia M., MSc Data Science Graduate", rating: 5, text: "Excellent mentors and highly structured modules. The thesis project allowed me to address a real-world predictive modeling problem at my workplace." }
      ]
    }
  ],

  programs: [
    {
      id: "london-met-global-mba",
      name: "Global Master of Business Administration",
      universityId: "london-met",
      degreeType: "MBA",
      category: "Management",
      duration: "18 Months",
      price: "$10,500",
      nextBatch: "September 15, 2026",
      overview: "The Global MBA at London Metropolitan University is designed for professionals seeking to advance to senior management and executive positions. The program delivers a strategic perspective on modern business enterprise operations, covering core functions like corporate finance, global supply systems, talent development, and digital marketing operations. Graduates receive the full UK Master's degree accredited globally.",
      curriculum: [
        "Strategic Management & Governance",
        "Global Financial Management & Decisioning",
        "Marketing Analytics in Digital Economies",
        "Operations and Supply Chain Strategy",
        "Leadership, Ethics & Talent Management",
        "Consulting Project / Dissertation"
      ],
      eligibility: "Bachelor's degree from a recognized university or equivalent professional qualification. A minimum of 2 years of professional work experience is recommended.",
      fees: "$10,500 total program fee. Easy installment plans are available at $580/month. No-cost EMI and financial aid options are available for eligible candidates.",
      careerOutcomes: "Graduates are equipped for global executive roles, including Director of Strategy, Management Consultant, Operations Manager, and Chief Executive Officer (CEO) across diverse private and public sector enterprises.",
      faqs: [
        { question: "Is this degree identical to the on-campus program?", answer: "Yes, the diploma and transcripts issued are identical. The certificate does not mention the online study mode." },
        { question: "Are exams conducted online?", answer: "Yes, all examinations and assessments are conducted 100% online through secure, proctored digital platforms." }
      ],
      popular: true,
      image: "https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=600&h=400&fit=crop&q=80"
    },
    {
      id: "ggu-dba",
      name: "Doctor of Business Administration (DBA)",
      universityId: "ggu-usa",
      degreeType: "DBA",
      category: "Management",
      duration: "36 Months",
      price: "$24,000",
      nextBatch: "August 28, 2026",
      overview: "GGU's Doctor of Business Administration (DBA) is a premium, research-focused doctoral program designed for C-suite executives, senior corporate consultants, and business school academicians. This 100% online doctoral program provides training in advanced research methodologies, corporate policy formulation, and quantitative data modeling to address complex organizational challenges. Learners receive guided mentorship from highly accomplished Silicon Valley faculty.",
      curriculum: [
        "Advanced Theory of Business & Management",
        "Quantitative Research Methodology & Models",
        "Qualitative Inquiry and Strategy",
        "Doctoral Dissertation Research Design",
        "Specialized Doctoral Seminars",
        "Doctoral Thesis Writing and Oral Defence"
      ],
      eligibility: "Master's degree (MBA, MS, or equivalent) in Business or a related field, along with a minimum of 5 years of professional leadership or corporate management experience.",
      fees: "$24,000 total tuition. Pay-as-you-go program modules or installment schedules starting at $660/month. Competitive corporate sponsorships accepted.",
      careerOutcomes: "Prepares you for executive leadership (CEO, Chief Strategy Officer), professional board-level consultation, executive business research, or university professorships.",
      faqs: [
        { question: "Is a residency required for the DBA?", answer: "No. The entire program, including the dissertation defense, is completed online with no mandatory physical travel." },
        { question: "How is the dissertation supervised?", answer: "You will be assigned a primary doctoral advisor from the GGU faculty who will guide you through your dissertation milestones." }
      ],
      popular: true,
      image: "https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=600&h=400&fit=crop&q=80"
    },
    {
      id: "ggu-ba-ms",
      name: "Master of Science in Business Analytics",
      universityId: "ggu-usa",
      degreeType: "Master's",
      category: "Technology & Data",
      duration: "12 Months",
      price: "$14,800",
      nextBatch: "September 02, 2026",
      overview: "Get equipped with specialized expertise to guide data-driven decisioning. The MS in Business Analytics at GGU blends predictive modeling, machine learning algorithms, and database management systems with real-world marketing and finance strategies. The program is ideal for business analysts, project managers, and engineers looking to step into business intelligence and corporate strategy roles.",
      curriculum: [
        "Introduction to Business Analytics & Big Data",
        "Statistical Models with R & Python",
        "Database Systems & SQL Structures",
        "Data Visualization & Tableau Metrics",
        "Predictive Modeling & Applied Machine Learning",
        "Business Intelligence Capstone Project"
      ],
      eligibility: "Bachelor's degree with a quantitative background (courses in statistics, economics, engineering, or mathematics). Professional resume and SOP are required.",
      fees: "$14,800 total fee. Payment options include monthly installments at $1,230/month or zero-interest financing options.",
      careerOutcomes: "Career directions include Business Intelligence Analyst, Data Analytics Manager, Strategy Consultant, and Marketing Operations Scientist.",
      faqs: [
        { question: "Do I need coding experience?", answer: "Prior experience with Python/R is helpful but not mandatory; the program includes foundation modules in data programming." }
      ],
      popular: false,
      image: "https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600&h=400&fit=crop&q=80"
    },
    {
      id: "iu-bba",
      name: "Bachelor of Business Administration (BBA)",
      universityId: "iu-germany",
      degreeType: "Bachelor's",
      category: "Management",
      duration: "36 Months",
      price: "$8,200",
      nextBatch: "Anytime (Flexible Start)",
      overview: "Start your career with a state-accredited European business degree. The IU Bachelor of Business Administration (BBA) is a comprehensive program designed to build strong foundations in corporate accounting, global marketing, business economics, and organizational leadership. Learners can select custom specializations like Digital Business, Entrepreneurship, or HR Management to align with their career goals.",
      curriculum: [
        "Principles of Business Administration",
        "Managerial Economics & Accountancy",
        "Collaborative Work & Communication",
        "Introduction to Marketing and Sales",
        "Specialization: Digital Business & Innovations",
        "Bachelor Thesis & Colloquium"
      ],
      eligibility: "Secondary school certificate (High School Diploma, International Baccalaureate, or equivalent). Proof of English language proficiency.",
      fees: "$8,200 total tuition. Highly flexible payment options starting at $220/month. Scholarship reductions of up to 40% are available based on regional eligibility.",
      careerOutcomes: "Entry-level executive roles in consulting, business administration, international sales, and public sector marketing departments.",
      faqs: [
        { question: "Can I study at my own pace?", answer: "Yes, IU offers three study models: full-time, part-time I, and part-time II, allowing you to extend your degree duration without extra cost." }
      ],
      popular: false,
      image: "https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=600&h=400&fit=crop&q=80"
    },
    {
      id: "chicago-state-mba",
      name: "Master of Business Administration",
      universityId: "chicago-state",
      degreeType: "MBA",
      category: "Management",
      duration: "12 Months",
      price: "$11,200",
      nextBatch: "August 10, 2026",
      overview: "The Master of Business Administration at Chicago State University is a high-yield, fast-track program aimed at professionals looking to scale up their career. The curriculum centers on real-world management case studies, tactical planning, corporate accounting systems, and marketing analytics. By completing this program in 12 months, learners bypass long academic timelines and immediately deploy senior business competencies in the corporate market.",
      curriculum: [
        "Administrative Organization and Policy",
        "Managerial Decision Science",
        "Advanced Marketing Strategy",
        "Corporate Finance & Strategy",
        "Management Information Architectures",
        "Strategic Capstone Synthesis"
      ],
      eligibility: "Completed Bachelor's degree with a minimum 2.75 GPA. Submission of official transcripts, resume, and two letters of recommendation.",
      fees: "$11,200 total program cost. Installments of $930/month over 12 months are available. Zero-interest credit partner terms are accepted.",
      careerOutcomes: "Qualifies graduates for corporate management, banking administration, management consulting, or startup operations leadership.",
      faqs: [
        { question: "Does this program require GMAT?", answer: "The GMAT is waived for candidates who have 2+ years of professional managerial experience or a high undergraduate GPA." }
      ],
      popular: true,
      image: "https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=600&h=400&fit=crop&q=80"
    },
    {
      id: "shiv-nadar-digital-finance-mba",
      name: "MBA in Digital Finance & FinTech",
      universityId: "shiv-nadar",
      degreeType: "MBA",
      category: "Healthcare", // Using Healthcare as a test domain for visual variety, or we'll filter categorially
      // Actually let's align Category names in schema to match prompt: "Management", "Technology & Data", "Healthcare", "Education"
      // We will place this in "Management" or "Technology & Data" and make a specific healthcare/education programs
      category: "Technology & Data",
      duration: "24 Months",
      price: "$9,000",
      nextBatch: "September 01, 2026",
      overview: "Delivered by Shiv Nadar University (an Institution of Eminence), this specialized MBA addresses the intersection of banking operations and advanced technology. Focus areas include robotic process automation in finance, blockchain ledgers, quantitative algorithms, and risk analytics. Developed in partnership with top financial analysts, this program prepares you for the high-paying fintech industry.",
      curriculum: [
        "Financial Markets and Valuation",
        "FinTech Ecosystems & Digital Enablers",
        "Artificial Intelligence in Banking",
        "Blockchain & Cryptographic Assets",
        "Quantitative Risk Management",
        "Digital Transformation Capstone Project"
      ],
      eligibility: "Bachelor's degree with minimum 50% marks. Strong numerical skills or foundation in computer/engineering science is highly recommended.",
      fees: "$9,000 total. Semestral installment plan at $2,250 per semester. Competitive corporate scholarships are open to institutional candidates.",
      careerOutcomes: "Roles in FinTech startup leadership, Digital Banking consultancy, Corporate Risk Analysis, and Algorithmic Operations Management.",
      faqs: [
        { question: "Is this degree UGC recognized?", answer: "Yes, Shiv Nadar University is recognized by the UGC, making this MBA valid for government opportunities and global PhD pathways." }
      ],
      popular: false,
      image: "https://images.unsplash.com/photo-1559526324-4b87b5e36e44?w=600&h=400&fit=crop&q=80"
    },
    {
      id: "ljmu-data-science-ms",
      name: "Master of Science in Data Science",
      universityId: "ljmu-uk",
      degreeType: "Master's",
      category: "Technology & Data",
      duration: "18 Months",
      price: "$13,200",
      nextBatch: "August 20, 2026",
      overview: "Developed by the expert computational science faculty at Liverpool John Moores University, this MSc in Data Science offers advanced skills in statistical modeling, machine learning, Python programming, and big data architectures. The program includes an in-depth research thesis, enabling learners to build sophisticated algorithms and solve real industrial problems using predictive analytics.",
      curriculum: [
        "Programming for Data Analytics",
        "Advanced Data Structures & Algorithms",
        "Applied Machine Learning Models",
        "Data Visualization & Storytelling",
        "Big Data Systems (Hadoop & Spark)",
        "MSc Research Thesis Project"
      ],
      eligibility: "Completed Bachelor's degree in Engineering, Computer Science, Statistics, or similar STEM field. Math proficiency is required.",
      fees: "$13,200 total program fee. Flexible payment plans of $730/month. Early bird reductions available.",
      careerOutcomes: "Qualifies you for elite titles including Senior Data Scientist, ML Engineer, Data Infrastructure Architect, and Analytics Director.",
      faqs: [
        { question: "Will I get alumni status from LJMU?", answer: "Yes, you will join the official global network of Liverpool John Moores University and receive invitations to global alumni summits." }
      ],
      popular: true,
      image: "https://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?w=600&h=400&fit=crop&q=80"
    },
    {
      id: "iu-comp-sci-bs",
      name: "Bachelor of Science in Computer Science",
      universityId: "iu-germany",
      degreeType: "Bachelor's",
      category: "Technology & Data",
      duration: "36 Months",
      price: "$9,400",
      nextBatch: "Anytime (Flexible Start)",
      overview: "Develop the coding foundation to excel globally. The IU B.Sc. in Computer Science focuses on key aspects of software engineering, database management, cloud computing, and AI architectures. The curriculum has been designed in accordance with German educational quality guidelines and is highly valued by tech companies worldwide.",
      curriculum: [
        "Introduction to Programming (Python/Java)",
        "Calculus and Statistics for Computing",
        "Data Structures and Database Systems",
        "Computer Networks and Cloud Security",
        "Machine Learning Foundations",
        "Bachelor Thesis Project"
      ],
      eligibility: "Completed high school/secondary school education. English language proficiency certifications are required.",
      fees: "$9,400 total. Affordable monthly payments starting at $260/month. Full digital learning platforms included.",
      careerOutcomes: "Roles in Software Engineering, Web Development, Cloud Management, Systems Administration, and AI Systems Design.",
      faqs: [
        { question: "Is the degree state accredited?", answer: "Yes, all IU programs are state-accredited by the German Accreditation Council, carrying full ECTS credit recognition." }
      ],
      popular: false,
      image: "https://images.unsplash.com/photo-1515879218367-8466d910aaa4?w=600&h=400&fit=crop&q=80"
    },
    {
      id: "iu-healthcare-management-master",
      name: "Master of Science in International Healthcare Management",
      universityId: "iu-germany",
      degreeType: "Master's",
      category: "Healthcare",
      duration: "18 Months",
      price: "$11,800",
      nextBatch: "September 10, 2026",
      overview: "Lead the health organizations of the future. The IU M.Sc. in International Healthcare Management prepares you for leadership roles in clinical environments, health consultancies, and pharmaceutical enterprises. The curriculum covers healthcare finance, strategic hospital management, global health policies, and operational analytics, aligning with European quality systems.",
      curriculum: [
        "Health Economics & Financing Systems",
        "Strategic Hospital Administration",
        "Global Health Policy & Regulations",
        "Quality and Risk Management in Health",
        "Leadership & Ethics in Medical Sectors",
        "Master Thesis & Defense Seminar"
      ],
      eligibility: "Completed Bachelor's degree (preferably in Health, Science, or Business). Minimum of 1 year of relevant professional experience.",
      fees: "$11,800 total. Easy monthly payments of $650/month are available. Scholarships apply dynamically.",
      careerOutcomes: "Positions include Clinical Operations Manager, Hospital Administrator, Health Consultant, and Health Sector Strategy Lead.",
      faqs: [
        { question: "Can I study this with a non-health background?", answer: "Yes, candidates holding a business or engineering degree who possess 1+ years of experience in the health sector are highly encouraged to apply." }
      ],
      popular: false,
      image: "https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=600&h=400&fit=crop&q=80"
    },
    {
      id: "london-met-education-ma",
      name: "Master of Arts in Education & Leadership",
      universityId: "london-met",
      degreeType: "Master's",
      category: "Education",
      duration: "12 Months",
      price: "$9,800",
      nextBatch: "August 15, 2026",
      overview: "Transform educational institutions with premium leadership skills. The MA in Education & Leadership at London Met targets curriculum developers, school principals, and academic administrators. The course covers educational policy analysis, administrative leadership models, curriculum innovations, and organizational management structures.",
      curriculum: [
        "Contemporary Issues in Education Policy",
        "Educational Leadership and Governance",
        "Innovative Curriculum Design Models",
        "Research Methods in Education Systems",
        "Strategic Resource Management",
        "Educational Thesis Project"
      ],
      eligibility: "Bachelor's degree with teaching/educational administration experience, or a degree in Education or Social Sciences.",
      fees: "$9,800 total. Monthly payment options available at $810/month. Financial aid available for qualifying global teachers.",
      careerOutcomes: "Career directions include School Principal, Academic Administrator, Curriculum Advisor, and Educational Consultant.",
      faqs: [
        { question: "Is this program helpful for corporate trainers?", answer: "Yes, many corporate learning and development (L&D) directors utilize this MA to structure company-wide training platforms." }
      ],
      popular: false,
      image: "https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=600&h=400&fit=crop&q=80"
    }
  ],

  blogPosts: [
    {
      id: "value-of-online-degrees-2026",
      title: "The Growing Value of Online Degrees in the 2026 Job Market",
      category: "Education Trends",
      excerpt: "Is an online university degree valued by recruiters? We analyze corporate hiring trends, remote work cultures, and the rising prestige of digital credentials.",
      content: `<p class="mb-4 text-charcoal leading-relaxed">As remote operations stabilize and professional systems transition into hybrid formats, global corporations are assessing applicants differently. Historically, traditional brick-and-mortar degrees were the gold standard. Today, recruiters value agility, self-discipline, and digital proficiency—qualities inherently demonstrated by successful online university graduates.</p>
      <p class="mb-4 text-charcoal leading-relaxed">Major tech and consulting institutions like IBM, Google, and Deloitte have officially removed traditional degree checkpoints for select executive and engineering ranks. In their place, they look for accredited credentials, practical capstones, and evidence of lifelong learning.</p>
      <blockquote class="border-l-4 border-brand-red pl-4 italic text-ink font-heading my-6">"An online degree shows that an employee can manage complex tasks autonomously, organize schedules, and master digital collaboration tools."</blockquote>
      <p class="mb-4 text-charcoal leading-relaxed">For working professionals, the choice is clear. Relocating to an expensive campus for two years incurs substantial opportunity costs. With online programs, learners retain their salary, apply new principles immediately at their desk, and acquire globally recognized credentials.</p>`,
      author: "Dr. Alistair Vance",
      authorAvatar: "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=80&h=80&fit=crop&q=80",
      date: "July 12, 2026",
      readTime: "5 min read",
      image: "https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&h=500&fit=crop&q=80"
    },
    {
      id: "how-to-choose-mba-program",
      title: "How to Choose the Right Online MBA Program for Your Goals",
      category: "Career Guide",
      excerpt: "Not all MBAs are created equal. Discover key factors to assess, including accreditation commissions, specialized tracks, alumni network size, and price tags.",
      content: `<p class="mb-4 text-charcoal leading-relaxed">Selecting an online MBA is a high-impact financial and career decision. With hundreds of options, professionals must look past simple advertising slogans to find the academic structure that matches their corporate goals.</p>
      <p class="mb-4 text-charcoal leading-relaxed">First and foremost, check the accreditation status. In the United States, look for regional accreditation such as WSCUC or HLC. For European and British options, ensure QAA or FIBAA approvals are present. Accreditation guarantees that your degree will be recognized by corporate entities, governments, and academic institutions worldwide.</p>
      <p class="mb-4 text-charcoal leading-relaxed">Second, examine the curriculum and specializations. If you operate in fintech, a general marketing MBA is less valuable than a technology-focused digital finance program. Make sure the university offers real-world capstone projects, enabling you to build tangible business plans or strategic reports.</p>`,
      author: "Sarah Jenkins, MBA Consultant",
      authorAvatar: "https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=80&h=80&fit=crop&q=80",
      date: "July 08, 2026",
      readTime: "6 min read",
      image: "https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=800&h=500&fit=crop&q=80"
    },
    {
      id: "rise-of-dba-doctorate",
      title: "The Rise of the DBA: Why Executives are Choosing Doctorates",
      category: "Executive Growth",
      excerpt: "Explore the differences between a PhD and a DBA, and understand why the Doctor of Business Administration is the ultimate credential for senior corporate leadership.",
      content: `<p class="mb-4 text-charcoal leading-relaxed">In the highest tiers of corporate administration, holding an MBA is no longer a distinct differentiator. To lead boards of directors, advise governments, and direct global strategy, top executives are pursuing terminal degrees. Specifically, they are turning to the Doctor of Business Administration (DBA).</p>
      <p class="mb-4 text-charcoal leading-relaxed">Unlike a traditional PhD, which is theoretical and prepares candidates for pure academic teaching, a DBA is highly applied. It focuses on taking academic research models and applying them to solve live, complex business problems.</p>
      <p class="mb-4 text-charcoal leading-relaxed">Through structured online research courses, a DBA candidate explores corporate governance, industrial relations, global market shifts, and technology adoption strategies. The culminating dissertation represents a peer-reviewed solution to an active corporate challenge.</p>`,
      author: "Prof. Gregory Stern",
      authorAvatar: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=80&h=80&fit=crop&q=80",
      date: "June 25, 2026",
      readTime: "4 min read",
      image: "https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=800&h=500&fit=crop&q=80"
    },
    {
      id: "balancing-online-study-and-work",
      title: "5 Strategies to Balance Online Studies with a Full-Time Job",
      category: "Learning Tips",
      excerpt: "Time management is the secret to succeeding in an online program. Learn how to allocate study slots, coordinate with family, and stay motivated.",
      content: `<p class="mb-4 text-charcoal leading-relaxed">Studying while managing a career is a major commitment. Without a physical campus to visit, it is easy to defer assignments. Successful online students rely on systems, not motivation, to complete their degrees.</p>
      <p class="mb-4 text-charcoal leading-relaxed">Here are five proven strategies from top online scholars:
        <ul class="list-disc pl-5 mb-4 text-charcoal space-y-2">
          <li><strong>Time-Blocking:</strong> Mark study blocks in your corporate calendar and treat them as non-negotiable executive meetings.</li>
          <li><strong>Communicate Boundaries:</strong> Inform family members and managers of your study schedules to prevent interruptions.</li>
          <li><strong>Apply Immediately:</strong> Solve work tasks using concepts from your classes. This reinforces memory and saves research time.</li>
          <li><strong>Utilize Micro-Learning:</strong> Read papers or listen to lectures during transit or gym sessions using mobile apps.</li>
        </ul>
      </p>`,
      author: "David Miller, Ed.D.",
      authorAvatar: "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=80&h=80&fit=crop&q=80",
      date: "June 19, 2026",
      readTime: "7 min read",
      image: "https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=800&h=500&fit=crop&q=80"
    },
    {
      id: "demystifying-university-accreditation",
      title: "Demystifying Accreditation: UK QAA vs. US Regional Commissions",
      category: "Admissions Info",
      excerpt: "Understand what makes a degree valid. We break down differences in international university accreditations, explaining what checks to verify.",
      content: `<p class="mb-4 text-charcoal leading-relaxed">When enrolling in a university marketplace, learners encounter multiple acronyms: WSCUC, HLC, QAA, FIBAA, UGC. What do they mean, and why should you care?</p>
      <p class="mb-4 text-charcoal leading-relaxed">Accreditation is the review process that certifies a college or university meets rigorous educational quality guidelines. Without accreditation, a degree is virtually useless in the corporate sector and will not be accepted for higher-degree pathways or immigration visa purposes.</p>
      <p class="mb-4 text-charcoal leading-relaxed">In the US, regional commissions are the gold standard. In the UK, the Quality Assurance Agency (QAA) certifies public universities. In Europe, agencies like FIBAA assess business and administration tracks. eDegree+ partners only with institutions possessing these top-tier clearances.</p>`,
      author: "Elena Petrova, Registrar",
      authorAvatar: "https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=80&h=80&fit=crop&q=80",
      date: "June 05, 2026",
      readTime: "5 min read",
      image: "https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=800&h=500&fit=crop&q=80"
    },
    {
      id: "tech-skills-in-business",
      title: "Why Technical Skills are Mandatory for Modern Business Leaders",
      category: "Executive Growth",
      excerpt: "Data analytics, machine learning, and cloud architecture are no longer just for software developers. Discover how leaders utilize tech to direct strategy.",
      content: `<p class="mb-4 text-charcoal leading-relaxed">The division between technical officers and business strategists has dissolved. Today, the most effective managers possess intermediate tech capabilities, enabling them to converse with data scientists and engineers and direct computational investments.</p>
      <p class="mb-4 text-charcoal leading-relaxed">Corporate systems generate billions of data points daily. Managers who can query databases with SQL, run statistics in R, or interpret machine learning dashboards make faster, more accurate decisions than competitors relying on instincts.</p>`,
      author: "Marcus Vance, CTO",
      authorAvatar: "https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=80&h=80&fit=crop&q=80",
      date: "May 28, 2026",
      readTime: "6 min read",
      image: "https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&h=500&fit=crop&q=80"
    }
  ],

  newsItems: [
    {
      id: "us-dept-of-education-approves-online-standards",
      title: "US Department of Education Standardizes Higher Distance Education Assessments",
      category: "EDUCATION POLICY",
      date: "JULY 18, 2026",
      readTime: "3 min read",
      dropCap: "T",
      excerpt: "New federal guidelines demand standardized assessment systems for online degree programs, boosting the global credibility of distance learning.",
      content: `The United States Department of Education has released a new regulatory framework standardizing distance learning assessments. Under the guidelines, online degrees must demonstrate equivalent academic contact hours and secure proctoring to maintain regional accreditation. Experts believe this framework will elevate the prestige of digital qualifications in recruitment, establishing parity between online programs and campus degrees.`
    },
    {
      id: "ggu-announces-expansion-of-online-doctoral-cohorts",
      title: "Golden Gate University Expands Online Doctoral Research Cohorts for Fall 2026",
      category: "UNIVERSITY UPDATES",
      date: "JULY 15, 2026",
      readTime: "2 min read",
      dropCap: "G",
      excerpt: "To address high application demand, GGU expands its DBA program capacities with 10 new research mentors specializing in AI governance.",
      content: `Golden Gate University has announced an expansion of its online Doctor of Business Administration (DBA) cohorts. Prompted by a 45% increase in applications from international tech executives, GGU is adding research mentors to oversee dissertations. The expansion focuses specifically on organizational policy, quantitative analytics, and ethical AI integration in corporate management.`
    },
    {
      id: "uk-university-tuition-reforms-affect-international-scholars",
      title: "UK Higher Education Reform Prompts Universities to Expand Online Transnational Degrees",
      category: "INTERNATIONAL EDUCATION",
      date: "JULY 02, 2026",
      readTime: "4 min read",
      dropCap: "A",
      excerpt: "Faced with tuition restructuring, British universities look to online degrees to deliver accredited programs to global students.",
      content: `A significant policy shift by the UK Higher Education funding council is driving public universities to expand their online transnational education (TNE) portfolios. By offering UK-accredited degrees online, institutions like London Metropolitan and Liverpool John Moores bypass local campus limits, offering affordable UK degrees to professionals across Asia, Africa, and the Americas.`
    },
    {
      id: "survey-reveals-82-percent-employers-value-online-mbas",
      title: "Global HR Association Survey: 82% of Recruiters Value Accredited Online MBAs",
      category: "MARKET RESEARCH",
      date: "JUNE 28, 2026",
      readTime: "3 min read",
      dropCap: "I",
      excerpt: "A study of 1,200 human resource executives shows strong support for online degrees, highlighting self-discipline as a major benefit.",
      content: `In a comprehensive survey conducted by the Global HR Association, 82% of recruiting officers stated they view an online MBA from an accredited institution with equal or higher value compared to traditional evening MBAs. Survey respondents emphasized that candidates holding online degrees demonstrate superior time-management and self-motivation skills.`
    },
    {
      id: "iu-germany-receives-five-star-online-learning-rating",
      title: "IU International University of Applied Sciences Receives Prestigious 5-Star QS Online Rating",
      category: "ACCOLADES",
      date: "JUNE 11, 2026",
      readTime: "2 min read",
      dropCap: "I",
      excerpt: "IU Germany secures maximum score from QS Stars assessment, ranking among the world's elite digital education systems.",
      content: `IU Germany has secured a five-star rating in the QS Stars Online Learning evaluation. The assessment checks student support systems, digital textbooks, online exam infrastructures, and faculty credentials. Achieving a 99% score in system reliability, IU joins a select group of European universities recognized for elite digital learning.`
    },
    {
      id: "fintech-jobs-surge-drives-specialized-mba-enrollment",
      title: "FinTech Sector Recruitment Surge Drives Record Enrollment in Digital Finance MBAs",
      category: "INDUSTRY ANALYSIS",
      date: "MAY 20, 2026",
      readTime: "3 min read",
      dropCap: "T",
      excerpt: "Demand for managers with dual business and tech proficiency triggers record applications in specialized finance programs.",
      content: `A hiring surge across banking technologies and algorithmic commerce has triggered unprecedented interest in specialized finance degrees. Financial platforms are seeking executives who possess solid regulatory knowledge alongside technical database abilities, prompting record enrollments in programs like Shiv Nadar's digital finance tracks.`
    }
  ]
};

// Search Autocomplete Suggestion Logic
function initializeSearchOverlay() {
  const searchInput = document.getElementById('search-input');
  const programTab = document.getElementById('search-tab-programs');
  const universityTab = document.getElementById('search-tab-universities');
  const suggestionList = document.getElementById('search-suggestions');

  if (!searchInput || !suggestionList) return;

  let activeSearchType = 'programs'; // default

  const toggleSearchTab = (type) => {
    activeSearchType = type;
    if (type === 'programs') {
      programTab.classList.add('border-brand-red', 'text-brand-red');
      programTab.classList.remove('border-transparent', 'text-charcoal');
      universityTab.classList.add('border-transparent', 'text-charcoal');
      universityTab.classList.remove('border-brand-red', 'text-brand-red');
    } else {
      universityTab.classList.add('border-brand-red', 'text-brand-red');
      universityTab.classList.remove('border-transparent', 'text-charcoal');
      programTab.classList.add('border-transparent', 'text-charcoal');
      programTab.classList.remove('border-brand-red', 'text-brand-red');
    }
    renderSuggestions(searchInput.value);
  };

  if (programTab && universityTab) {
    programTab.addEventListener('click', () => toggleSearchTab('programs'));
    universityTab.addEventListener('click', () => toggleSearchTab('universities'));
  }

  const renderSuggestions = (query) => {
    suggestionList.innerHTML = '';
    const cleanQuery = query.toLowerCase().trim();
    if (!cleanQuery) return;

    let matches = [];
    if (activeSearchType === 'programs') {
      matches = eDegreeDb.programs.filter(p => 
        p.name.toLowerCase().includes(cleanQuery) || 
        p.degreeType.toLowerCase().includes(cleanQuery) ||
        p.category.toLowerCase().includes(cleanQuery)
      ).slice(0, 5);
      
      matches.forEach(item => {
        const uni = eDegreeDb.universities.find(u => u.id === item.universityId);
        const li = document.createElement('li');
        li.className = 'p-3 hover:bg-brand-tint cursor-pointer rounded-lg flex justify-between items-center transition-colors duration-150 gap-4';
        li.innerHTML = `
          <div class="min-w-0 flex-1">
            <div class="font-heading font-medium text-ink text-sm break-words">${item.name}</div>
            <div class="text-xs text-mutedGray break-words">${uni ? uni.name : ''} &middot; ${item.degreeType}</div>
          </div>
          <span class="text-brand-red text-xs font-semibold whitespace-nowrap flex-shrink-0 ml-2">View Program &rarr;</span>
        `;
        li.addEventListener('click', () => {
          window.location.href = `program-single.html?id=${item.id}`;
        });
        suggestionList.appendChild(li);
      });
    } else {
      matches = eDegreeDb.universities.filter(u => 
        u.name.toLowerCase().includes(cleanQuery) || 
        u.location.toLowerCase().includes(cleanQuery)
      ).slice(0, 5);

      matches.forEach(item => {
        const li = document.createElement('li');
        li.className = 'p-3 hover:bg-brand-tint cursor-pointer rounded-lg flex justify-between items-center transition-colors duration-150 gap-4';
        li.innerHTML = `
          <div class="min-w-0 flex-1">
            <div class="font-heading font-medium text-ink text-sm break-words">${item.name}</div>
            <div class="text-xs text-mutedGray break-words">${item.location} &middot; ${item.programsCount} Programs</div>
          </div>
          <span class="text-brand-red text-xs font-semibold whitespace-nowrap flex-shrink-0 ml-2">View University &rarr;</span>
        `;
        li.addEventListener('click', () => {
          window.location.href = `/universities/${item.id}`;
        });
        suggestionList.appendChild(li);
      });
    }

    if (matches.length === 0) {
      const li = document.createElement('li');
      li.className = 'p-4 text-center text-sm text-mutedGray';
      li.innerText = 'No matching programs or universities found.';
      suggestionList.appendChild(li);
    }
  };

  searchInput.addEventListener('input', (e) => {
    renderSuggestions(e.target.value);
  });
}

// Global Alpine Initialization
document.addEventListener('alpine:init', () => {
  // Global Store for Shared Site Functions
  Alpine.store('global', {
    mobileMenuOpen: false,
    searchModalOpen: false,
    isScrolled: false,
    
    toggleMobileMenu() {
      this.mobileMenuOpen = !this.mobileMenuOpen;
    },
    toggleSearchModal() {
      this.searchModalOpen = !this.searchModalOpen;
      if (this.searchModalOpen) {
        setTimeout(() => {
          const input = document.getElementById('search-input');
          if (input) input.focus();
        }, 100);
      }
    },
    checkScroll() {
      this.isScrolled = window.scrollY > 20;
    }
  });

  // Subscribe Box logic
  Alpine.data('subscribeSection', () => ({
    email: '',
    success: false,
    error: '',
    submitSubscribe() {
      this.error = '';
      if (!this.email) {
        this.error = 'Email is required';
        return;
      }
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(this.email)) {
        this.error = 'Please enter a valid email address';
        return;
      }
      this.success = true;
      this.email = '';
      setTimeout(() => {
        this.success = false;
      }, 5000);
    }
  }));

  // Programs Grid with dynamic filtering
  Alpine.data('programsGrid', (limit = 0) => ({
    allPrograms: eDegreeDb.programs,
    selectedCategory: 'All',
    selectedDegree: 'All',
    searchTerm: '',
    categories: ['All', 'Management', 'Technology & Data', 'Healthcare', 'Education'],
    degrees: ['All', 'MBA', 'DBA', 'Master\'s', 'Bachelor\'s'],
    
    get filteredPrograms() {
      let result = this.allPrograms;
      if (this.selectedCategory !== 'All') {
        result = result.filter(p => p.category === this.selectedCategory);
      }
      if (this.selectedDegree !== 'All') {
        result = result.filter(p => p.degreeType === this.selectedDegree);
      }
      if (this.searchTerm) {
        const query = this.searchTerm.toLowerCase().trim();
        result = result.filter(p => 
          p.name.toLowerCase().includes(query) ||
          this.getUniversityName(p.universityId).toLowerCase().includes(query)
        );
      }
      if (limit > 0) {
        return result.slice(0, limit);
      }
      return result;
    },
    
    getUniversityName(id) {
      const u = eDegreeDb.universities.find(uni => uni.id === id);
      return u ? u.name : '';
    },
    
    getUniversityLogoUrl(id) {
      const u = eDegreeDb.universities.find(uni => uni.id === id);
      return u ? u.logoUrl : '';
    }
  }));

  // University listing page controller
  Alpine.data('universityGrid', () => ({
    universities: eDegreeDb.universities,
    searchTerm: '',
    
    get filteredUniversities() {
      if (!this.searchTerm) return this.universities;
      const query = this.searchTerm.toLowerCase().trim();
      return this.universities.filter(u => 
        u.name.toLowerCase().includes(query) || 
        u.location.toLowerCase().includes(query) ||
        u.accreditation.toLowerCase().includes(query)
      );
    }
  }));

  // Dynamic Single Program details loader
  Alpine.data('programSingle', () => ({
    program: null,
    university: null,
    relatedPrograms: [],
    loading: true,
    activeTab: 'overview',
    inquiryForm: { name: '', email: '', phone: '', message: '', success: false, error: '' },
    
    init() {
      const params = new URLSearchParams(window.location.search);
      const programId = params.get('id');
      this.program = eDegreeDb.programs.find(p => p.id === programId);
      if (!this.program) {
        // Fallback or redirection
        this.program = eDegreeDb.programs[0];
      }
      this.university = eDegreeDb.universities.find(u => u.id === this.program.universityId);
      this.relatedPrograms = eDegreeDb.programs.filter(p => p.category === this.program.category && p.id !== this.program.id).slice(0, 3);
      this.loading = false;
    },
    
    submitInquiry() {
      this.inquiryForm.error = '';
      if (!this.inquiryForm.name || !this.inquiryForm.email || !this.inquiryForm.phone) {
        this.inquiryForm.error = 'Please fill out name, email, and phone.';
        return;
      }
      this.inquiryForm.success = true;
      setTimeout(() => {
        this.inquiryForm.success = false;
        this.inquiryForm.name = '';
        this.inquiryForm.email = '';
        this.inquiryForm.phone = '';
        this.inquiryForm.message = '';
      }, 5000);
    }
  }));

  Alpine.data('universitySingle', () => ({
    university: null,
    programs: [],
    loading: true,
    activeTab: 'programs',
    inquiryForm: { name: '', email: '', phone: '', success: false },
    
    init() {
      const params = new URLSearchParams(window.location.search);
      const uniId = params.get('id');
      this.university = eDegreeDb.universities.find(u => u.id === uniId);
      if (!this.university) {
        this.university = eDegreeDb.universities[0];
      }
      this.programs = eDegreeDb.programs.filter(p => p.universityId === this.university.id);
      this.loading = false;
    },
    
    submitInquiry() {
      this.inquiryForm.success = true;
      setTimeout(() => {
        this.inquiryForm.success = false;
        this.inquiryForm.name = '';
        this.inquiryForm.email = '';
        this.inquiryForm.phone = '';
      }, 5000);
    }
  }));

  // Blog archive and simulated load-more controller
  Alpine.data('blogArchive', () => ({
    posts: eDegreeDb.blogPosts,
    selectedCategory: 'All',
    visibleCount: 4,
    categories: ['All', 'Education Trends', 'Career Guide', 'Executive Growth', 'Learning Tips', 'Admissions Info'],
    
    get filteredPosts() {
      let result = this.posts;
      if (this.selectedCategory !== 'All') {
        result = result.filter(p => p.category === this.selectedCategory);
      }
      return result.slice(0, this.visibleCount);
    },
    
    get hasMore() {
      let result = this.posts;
      if (this.selectedCategory !== 'All') {
        result = result.filter(p => p.category === this.selectedCategory);
      }
      return this.visibleCount < result.length;
    },
    
    loadMore() {
      this.visibleCount += 4;
    }
  }));

  // Dynamic Single Blog details loader
  Alpine.data('blogSingle', () => ({
    post: null,
    recentPosts: [],
    loading: true,
    
    init() {
      const params = new URLSearchParams(window.location.search);
      const postId = params.get('id');
      this.post = eDegreeDb.blogPosts.find(p => p.id === postId);
      if (!this.post) {
        this.post = eDegreeDb.blogPosts[0];
      }
      this.recentPosts = eDegreeDb.blogPosts.filter(p => p.id !== this.post.id).slice(0, 3);
      this.loading = false;
    }
  }));

  // News Archive controller
  Alpine.data('newsArchive', () => ({
    news: eDegreeDb.newsItems,
    visibleCount: 4,
    
    get filteredNews() {
      return this.news.slice(0, this.visibleCount);
    },
    
    get hasMore() {
      return this.visibleCount < this.news.length;
    },
    
    loadMore() {
      this.visibleCount += 3;
    }
  }));

  // Dynamic Single News details loader
  Alpine.data('newsSingle', () => ({
    newsItem: null,
    recentNews: [],
    loading: true,
    
    init() {
      const params = new URLSearchParams(window.location.search);
      const newsId = params.get('id');
      this.newsItem = eDegreeDb.newsItems.find(n => n.id === newsId);
      if (!this.newsItem) {
        this.newsItem = eDegreeDb.newsItems[0];
      }
      this.recentNews = eDegreeDb.newsItems.filter(n => n.id !== this.newsItem.id).slice(0, 3);
      this.loading = false;
    }
  }));

  // Dynamic Home Page controller (for search inputs)
  Alpine.data('homePage', () => ({
    searchType: 'program', // or 'university'
    query: '',
    degreeLevel: 'All',
    category: 'All',
    
    submitSearch() {
      if (this.searchType === 'program') {
        window.location.href = `programs.html?query=${encodeURIComponent(this.query)}&degree=${encodeURIComponent(this.degreeLevel)}&category=${encodeURIComponent(this.category)}`;
      } else {
        window.location.href = `/universities?query=${encodeURIComponent(this.query)}`;
      }
    }
  }));
});

// Scroll Listener for Sticky Nav
window.addEventListener('scroll', () => {
  const store = Alpine.store('global');
  if (store) {
    store.checkScroll();
  }
});

// Document Ready Initialization
document.addEventListener('DOMContentLoaded', () => {
  // Initialize Lucide Icons
  if (typeof lucide !== 'undefined') {
    lucide.createIcons();
  }

  // Bind Navbar Live Search Modal Toggles
  initializeSearchOverlay();

  // Scroll to Top logic
  const backToTopBtn = document.createElement('button');
  backToTopBtn.className = 'fixed bottom-6 right-6 bg-brand-red text-white p-3 rounded-full shadow-lg opacity-0 hover:bg-brand-darkRed transition-all duration-300 transform translate-y-10 z-40 focus:outline-none';
  backToTopBtn.innerHTML = `<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>`;
  document.body.appendChild(backToTopBtn);

  window.addEventListener('scroll', () => {
    if (window.scrollY > 400) {
      backToTopBtn.classList.remove('opacity-0', 'translate-y-10');
      backToTopBtn.classList.add('opacity-100', 'translate-y-0');
    } else {
      backToTopBtn.classList.add('opacity-0', 'translate-y-10');
      backToTopBtn.classList.remove('opacity-100', 'translate-y-0');
    }
  });

  backToTopBtn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });

  // Check URL parameters for home search redirect on programs/universities archive
  const urlParams = new URLSearchParams(window.location.search);
  const homeQuery = urlParams.get('query');
  const homeDegree = urlParams.get('degree');
  const homeCategory = urlParams.get('category');
  
  setTimeout(() => {
    // If we're on the programs page, inject parameters into the grid search controls
    const gridEl = document.querySelector('[x-data^="programsGrid"]');
    if (gridEl && (homeQuery || homeDegree || homeCategory)) {
      const alpineGrid = gridEl.__x.$data;
      if (alpineGrid) {
        if (homeQuery && homeQuery !== 'null') alpineGrid.searchTerm = homeQuery;
        if (homeDegree && homeDegree !== 'All') alpineGrid.selectedDegree = homeDegree;
        if (homeCategory && homeCategory !== 'All') alpineGrid.selectedCategory = homeCategory;
      }
    }

    // If we're on the universities page, inject parameters into the search controls
    const uniEl = document.querySelector('[x-data^="universityGrid"]');
    if (uniEl && homeQuery) {
      const alpineUni = uniEl.__x.$data;
      if (alpineUni) {
        alpineUni.searchTerm = homeQuery;
      }
    }
  }, 300);
});
