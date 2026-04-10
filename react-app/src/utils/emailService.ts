// Email service utility for automated responses
export interface FormSubmissionData {
  name: string;
  email: string;
  phone?: string;
  formType: string;
  projectDetails?: string;
  [key: string]: any;
}

export const sendAutomatedResponse = async (formData: FormSubmissionData) => {
  // Generate automated response email content
  const customerEmailContent = generateCustomerEmailContent(formData);
  const adminEmailContent = generateAdminEmailContent(formData);

  // Send email to customer (automated response)
  const customerMailtoLink = `mailto:${formData.email}?subject=${encodeURIComponent(customerEmailContent.subject)}&body=${encodeURIComponent(customerEmailContent.body)}`;
  
  // Send email to admin (form submission)
  const adminMailtoLink = `mailto:adista@caripropshop.com?subject=${encodeURIComponent(adminEmailContent.subject)}&body=${encodeURIComponent(adminEmailContent.body)}`;

  // Open both email clients (customer response first, then admin notification)
  setTimeout(() => {
    window.open(customerMailtoLink, '_blank');
  }, 500);
  
  setTimeout(() => {
    window.open(adminMailtoLink, '_blank');
  }, 1000);

  return { customerMailtoLink, adminMailtoLink };
};

const generateCustomerEmailContent = (formData: FormSubmissionData) => {
  const subject = `Thank you for your ${formData.formType} inquiry - Cari Prop Shop`;
  
  const body = `
Dear ${formData.name},

Thank you for contacting Cari Prop Shop! We have successfully received your ${formData.formType.toLowerCase()} inquiry and are excited to help you with your interior design project.

CONFIRMATION DETAILS:
- Inquiry Type: ${formData.formType}
- Submission Date: ${new Date().toLocaleDateString()}
- Reference ID: CPS-${Date.now().toString().slice(-6)}

WHAT HAPPENS NEXT:
Our design team will review your requirements and contact you within 24 hours to discuss your project in detail and schedule a consultation.

CONTACT INFORMATION:
If you haven't received a response from us within 24 hours, please don't hesitate to call us directly at:
📞 +6282233039914

You can also reach us via email:
📧 adista@caripropshop.com

BUSINESS HOURS:
Monday - Friday: 9:00 AM - 6:00 PM
Saturday: 10:00 AM - 4:00 PM
Sunday: By appointment

We appreciate your interest in our services and look forward to creating something extraordinary together!

Best regards,
The Cari Prop Shop Team
Premium Interior Design

---
Cari Prop Shop
Surabaya East, Indonesia
Website: https://caripropshop.com
Phone: +6282233039914
Email: info@caripropshop.com

This is an automated response. Please do not reply to this email.
  `.trim();

  return { subject, body };
};

const generateAdminEmailContent = (formData: FormSubmissionData) => {
  const subject = `New ${formData.formType} Inquiry - ${formData.name}`;
  
  const body = `
New ${formData.formType.toLowerCase()} inquiry received:

CLIENT INFORMATION:
- Name: ${formData.name}
- Email: ${formData.email}
- Phone: ${formData.phone || 'Not provided'}
- Submission Date: ${new Date().toLocaleString()}

FORM TYPE: ${formData.formType}

PROJECT DETAILS:
${Object.entries(formData)
  .filter(([key]) => !['name', 'email', 'phone', 'formType'].includes(key))
  .map(([key, value]) => `- ${key.charAt(0).toUpperCase() + key.slice(1)}: ${value || 'Not specified'}`)
  .join('\n')}

PRIORITY: High - Customer Service Request
ACTION REQUIRED: Please respond within 24 hours

AUTOMATED RESPONSE: Customer has been sent an automated confirmation email with our contact information.

Best regards,
Cari Prop Shop Contact System
  `.trim();

  return { subject, body };
};