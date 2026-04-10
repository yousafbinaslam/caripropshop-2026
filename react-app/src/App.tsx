import React, { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion'; 
import { BrowserRouter as Router, Routes, Route, useLocation } from 'react-router-dom';
import Header from './components/Header';
import Hero from './components/Hero';
import About from './components/About';
import Services from './components/Services';
import StyleGuide from './components/StyleGuide';
import StyleDetail from './components/StyleDetail';
import Process from './components/Process';
import Testimonials from './components/Testimonials';
import Contact from './components/Contact';
import Footer from './components/Footer';
import ProjectModal from './components/ProjectModal';
import PrivacyPolicy from './components/PrivacyPolicy';
import TermsConditions from './components/TermsConditions';
import ServiceAgreement from './components/ServiceAgreement';
import RefundPolicy from './components/RefundPolicy';
import CopyrightNotice from './components/CopyrightNotice';
import ProfessionalStandards from './components/ProfessionalStandards';
import QualityAssuranceStandards from './components/QualityAssuranceStandards';
import ClientRightsProtections from './components/ClientRightsProtections';
import DisputeResolution from './components/DisputeResolution';
import AccessibilityCompliance from './components/AccessibilityCompliance';
import BuildingCompliance from './components/BuildingCompliance';
import InsuranceLiability from './components/InsuranceLiability';
import EnvironmentalCompliance from './components/EnvironmentalCompliance';
import DataProtection from './components/DataProtection';
import LightingDesign from './components/LightingDesign';
import ProjectManagement from './components/ProjectManagement';
import ResidentialDesign from './components/ResidentialDesign';
import CommercialDesign from './components/CommercialDesign';
import DesignConsultation from './components/DesignConsultation';
import SpacePlanning from './components/SpacePlanning';
import { Project } from './types/portfolio';

const HomePage: React.FC = () => {
  return (
    <div className="pt-20">
      <Header />
      <Hero />
      <About />
      <Services />
      <StyleGuide />
      <Process />
      <Testimonials />
      <Contact />
    </div>
  );
};

// ScrollToTop component to handle automatic scrolling
const ScrollToTop: React.FC = () => {
  const { pathname } = useLocation();
  
  React.useEffect(() => {
    window.scrollTo(0, 0);
  }, [pathname]);
  
  return null;
};

function App() {
  return (
    <Router>
      <div className="min-h-screen bg-white">
        <ScrollToTop />
        <Routes>
          <Route path="/" element={<HomePage />} />
          <Route path="/style/:styleId" element={<StyleDetail />} />
          <Route path="/privacy-policy" element={<PrivacyPolicy />} />
          <Route path="/terms-conditions" element={<TermsConditions />} />
          <Route path="/service-agreement" element={<ServiceAgreement />} />
          <Route path="/refund-policy" element={<RefundPolicy />} />
          <Route path="/copyright-notice" element={<CopyrightNotice />} />
          <Route path="/professional-standards" element={<ProfessionalStandards />} />
          <Route path="/quality-assurance-standards" element={<QualityAssuranceStandards />} />
          <Route path="/client-rights-protections" element={<ClientRightsProtections />} />
          <Route path="/dispute-resolution" element={<DisputeResolution />} />
          <Route path="/accessibility-compliance" element={<AccessibilityCompliance />} />
          <Route path="/building-compliance" element={<BuildingCompliance />} />
          <Route path="/insurance-liability" element={<InsuranceLiability />} />
          <Route path="/environmental-compliance" element={<EnvironmentalCompliance />} />
          <Route path="/data-protection" element={<DataProtection />} />
          <Route path="/lighting-design" element={<LightingDesign />} />
          <Route path="/project-management" element={<ProjectManagement />} />
          <Route path="/residential-design" element={<ResidentialDesign />} />
          <Route path="/commercial-design" element={<CommercialDesign />} />
          <Route path="/design-consultation" element={<DesignConsultation />} />
          <Route path="/space-planning" element={<SpacePlanning />} />
        </Routes>
        <Footer />
      </div>
    </Router>
  );
}

export default App;