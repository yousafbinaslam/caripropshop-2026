import React, { useState } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { Lightbulb, Zap, Sun, Moon, Settings, Eye, Palette, CheckCircle, Send, Phone, Mail, ArrowLeft } from 'lucide-react';
import { sendAutomatedResponse } from '../utils/emailService';
import Header from './Header';

const LightingDesign: React.FC = () => {
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    phone: '',
    projectType: '',
    spaceSize: '',
    lightingNeeds: '',
    timeline: '',
    message: ''
  });
  const [isSubmitted, setIsSubmitted] = useState(false);

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    
    // Send automated response and admin notification
    sendAutomatedResponse({
      name: formData.name,
      email: formData.email,
      phone: formData.phone,
      formType: 'Lighting Design Consultation',
      projectType: formData.projectType,
      spaceSize: formData.spaceSize,
      lightingNeeds: formData.lightingNeeds,
      timeline: formData.timeline,
      message: formData.message
    });
    
    // Show success message
    setIsSubmitted(true);
    setTimeout(() => setIsSubmitted(false), 3000);
    setFormData({
      name: '',
      email: '',
      phone: '',
      projectType: '',
      spaceSize: '',
      lightingNeeds: '',
      timeline: '',
      message: ''
    });
  };

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value
    });
  };

  return (
    <div className="min-h-screen bg-gray-50">
      <Header />
      <div className="pt-20">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="py-20">
            {/* Back Navigation */}
            <motion.div
              initial={{ opacity: 0, x: -20 }}
              animate={{ opacity: 1, x: 0 }}
              className="mb-8"
            >
              <Link to="/" className="flex items-center text-amber-600 hover:text-amber-700 transition-colors">
                <ArrowLeft className="w-5 h-5 mr-2" />
                Back to Home
              </Link>
            </motion.div>

            {/* Hero Section */}
            <motion.div
              initial={{ opacity: 0, y: 30 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.8 }}
              className="text-center mb-16"
            >
          <div className="flex justify-center mb-6">
            <div className="w-20 h-20 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center">
              <Lightbulb className="w-10 h-10 text-white" />
            </div>
          </div>
          <h1 className="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
            Professional Lighting Design
          </h1>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Transform your space with expertly designed lighting solutions that enhance ambiance, 
            functionality, and energy efficiency. Our lighting specialists create custom solutions 
            for every environment.
          </p>
        </motion.div>

        {/* Services Overview */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.2 }}
          className="grid md:grid-cols-3 gap-8 mb-16"
        >
          {[
            {
              icon: Sun,
              title: 'Natural Light Integration',
              description: 'Maximize natural light with strategic placement and daylight harvesting systems',
              features: ['Skylight design', 'Window optimization', 'Light shelves', 'Solar tubes']
            },
            {
              icon: Zap,
              title: 'Artificial Lighting Systems',
              description: 'Custom LED and smart lighting solutions for every space and purpose',
              features: ['LED systems', 'Smart controls', 'Dimming solutions', 'Color temperature']
            },
            {
              icon: Settings,
              title: 'Lighting Control Systems',
              description: 'Advanced automation and control systems for optimal lighting management',
              features: ['Smart switches', 'Automated schedules', 'Scene programming', 'Energy monitoring']
            }
          ].map((service, index) => (
            <motion.div
              key={index}
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6, delay: 0.3 + index * 0.1 }}
              className="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow"
            >
              <service.icon className="w-12 h-12 text-yellow-500 mb-6" />
              <h3 className="text-xl font-bold text-gray-900 mb-4">{service.title}</h3>
              <p className="text-gray-600 mb-6">{service.description}</p>
              <ul className="space-y-2">
                {service.features.map((feature, i) => (
                  <li key={i} className="flex items-center text-gray-700">
                    <CheckCircle className="w-4 h-4 text-green-500 mr-3" />
                    {feature}
                  </li>
                ))}
              </ul>
            </motion.div>
          ))}
        </motion.div>

        {/* Lighting Types */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.4 }}
          className="bg-white rounded-2xl p-8 shadow-lg mb-16"
        >
          <h2 className="text-3xl font-bold text-gray-900 text-center mb-12">Comprehensive Lighting Solutions</h2>
          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            {[
              {
                icon: Sun,
                title: 'Ambient Lighting',
                description: 'General illumination for overall room brightness and comfort'
              },
              {
                icon: Eye,
                title: 'Task Lighting',
                description: 'Focused lighting for specific activities like reading or cooking'
              },
              {
                icon: Palette,
                title: 'Accent Lighting',
                description: 'Decorative lighting to highlight features and create visual interest'
              },
              {
                icon: Moon,
                title: 'Mood Lighting',
                description: 'Atmospheric lighting to create ambiance and emotional responses'
              }
            ].map((type, index) => (
              <div key={index} className="text-center">
                <div className="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                  <type.icon className="w-8 h-8 text-yellow-600" />
                </div>
                <h3 className="text-lg font-semibold text-gray-900 mb-3">{type.title}</h3>
                <p className="text-gray-600 text-sm">{type.description}</p>
              </div>
            ))}
          </div>
        </motion.div>

        {/* Process & Consultation */}
        <div className="grid lg:grid-cols-2 gap-12 mb-16">
          <motion.div
            initial={{ opacity: 0, x: -20 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.8, delay: 0.5 }}
            className="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl p-8"
          >
            <h2 className="text-2xl font-bold text-gray-900 mb-6">Our Design Process</h2>
            <div className="space-y-6">
              {[
                { step: '1', title: 'Consultation & Assessment', desc: 'Site visit and lighting needs analysis' },
                { step: '2', title: 'Design Development', desc: 'Custom lighting plan and 3D visualization' },
                { step: '3', title: 'Product Selection', desc: 'Fixture and control system specification' },
                { step: '4', title: 'Installation Coordination', desc: 'Project management and quality control' },
                { step: '5', title: 'Testing & Optimization', desc: 'System commissioning and fine-tuning' }
              ].map((phase, index) => (
                <div key={index} className="flex items-start">
                  <div className="w-8 h-8 bg-yellow-500 text-white rounded-full flex items-center justify-center font-bold text-sm mr-4 mt-1">
                    {phase.step}
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-1">{phase.title}</h3>
                    <p className="text-gray-600 text-sm">{phase.desc}</p>
                  </div>
                </div>
              ))}
            </div>
          </motion.div>

          <motion.div
            initial={{ opacity: 0, x: 20 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.8, delay: 0.6 }}
            className="bg-white rounded-2xl p-8 shadow-lg"
          >
            <h2 className="text-2xl font-bold text-gray-900 mb-6">Consultation Services</h2>
            
            {/* Consultation Notice */}
            <div className="bg-amber-50 rounded-lg p-6 mb-6 border-l-4 border-amber-500">
              <h3 className="font-semibold text-gray-900 mb-2">📋 Consultation Charges</h3>
              <p className="text-gray-700 text-sm mb-3">
                All lighting consultations are billed on hourly basis to ensure personalized attention and expert guidance.
              </p>
              <p className="text-amber-700 font-medium text-sm">Consult Now for detailed pricing and custom solutions</p>
            </div>

            <div className="space-y-6">
              {[
                {
                  package: 'Lighting Consultation',
                  includes: ['Site assessment', 'Lighting plan', 'Product recommendations', 'Implementation guide']
                },
                {
                  package: 'Complete Lighting Design',
                  includes: ['Full design service', '3D visualizations', 'Detailed specifications', 'Installation support']
                },
                {
                  package: 'Premium Lighting Service',
                  includes: ['End-to-end service', 'Contractor coordination', 'Quality control', 'System commissioning']
                }
              ].map((pkg, index) => (
                <div key={index} className="border border-gray-200 rounded-lg p-4">
                  <div className="flex justify-between items-start mb-3">
                    <h3 className="font-semibold text-gray-900">{pkg.package}</h3>
                    <span className="text-yellow-600 font-bold">Consult Now</span>
                  </div>
                  <ul className="space-y-1">
                    {pkg.includes.map((item, i) => (
                      <li key={i} className="text-gray-600 text-sm flex items-center">
                        <CheckCircle className="w-3 h-3 text-green-500 mr-2" />
                        {item}
                      </li>
                    ))}
                  </ul>
                </div>
              ))}
            </div>
          </motion.div>
        </div>

        {/* Contact Form */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.7 }}
          className="bg-white rounded-2xl p-8 shadow-lg"
        >
          <div className="grid lg:grid-cols-2 gap-12">
            <div>
              <h2 className="text-3xl font-bold text-gray-900 mb-6">Get Your Lighting Consultation</h2>
              <p className="text-gray-600 mb-8">
                Ready to transform your space with professional lighting design? Contact our lighting specialists 
                for a personalized consultation and custom lighting solution.
              </p>
              
              <div className="space-y-4">
                <div className="flex items-center">
                  <Phone className="w-5 h-5 text-yellow-500 mr-3" />
                  <div>
                    <p className="font-medium text-gray-900">Direct Line</p>
                    <p className="text-gray-600">+6282233039914</p>
                  </div>
                </div>
                <div className="flex items-center">
                  <Mail className="w-5 h-5 text-yellow-500 mr-3" />
                  <div>
                    <p className="font-medium text-gray-900">Lighting Design Team</p>
                    <p className="text-gray-600">lighting@caripropshop.com</p>
                  </div>
                </div>
              </div>

              {/* Hourly Consultation Notice */}
              <div className="mt-8 p-4 bg-yellow-50 rounded-lg border-l-4 border-yellow-500">
                <h3 className="font-semibold text-gray-900 mb-2">⏰ Hourly Consultation</h3>
                <p className="text-gray-700 text-sm">
                  Our lighting consultations are charged on hourly basis, ensuring you receive dedicated attention and value for your investment.
                </p>
              </div>
            </div>

            <div>
              {isSubmitted ? (
                <motion.div
                  initial={{ opacity: 0, scale: 0.9 }}
                  animate={{ opacity: 1, scale: 1 }}
                  className="text-center py-8"
                >
                  <CheckCircle className="w-16 h-16 text-green-500 mx-auto mb-4" />
                  <h3 className="text-xl font-semibold text-gray-900 mb-2">Request Sent!</h3>
                  <p className="text-gray-600">
                    Our lighting design team will contact you within 24 hours to schedule your consultation.
                  </p>
                </motion.div>
              ) : (
                <form onSubmit={handleSubmit} className="space-y-4">
                  <div className="grid md:grid-cols-2 gap-4">
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                      <input
                        type="text"
                        name="name"
                        value={formData.name}
                        onChange={handleChange}
                        required
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                        placeholder="Your full name"
                      />
                    </div>
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                      <input
                        type="email"
                        name="email"
                        value={formData.email}
                        onChange={handleChange}
                        required
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                        placeholder="your@email.com"
                      />
                    </div>
                  </div>

                  <div className="grid md:grid-cols-2 gap-4">
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                      <input
                        type="tel"
                        name="phone"
                        value={formData.phone}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                        placeholder="+62 xxx xxx xxxx"
                      />
                    </div>
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Project Type *</label>
                      <select
                        name="projectType"
                        value={formData.projectType}
                        onChange={handleChange}
                        required
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                      >
                        <option value="">Select project type</option>
                        <option value="residential">Residential</option>
                        <option value="commercial">Commercial</option>
                        <option value="hospitality">Hospitality</option>
                        <option value="retail">Retail</option>
                        <option value="outdoor">Outdoor/Landscape</option>
                      </select>
                    </div>
                  </div>

                  <div className="grid md:grid-cols-2 gap-4">
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Space Size</label>
                      <input
                        type="text"
                        name="spaceSize"
                        value={formData.spaceSize}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                        placeholder="e.g., 200 sqm"
                      />
                    </div>
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Timeline</label>
                      <select
                        name="timeline"
                        value={formData.timeline}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                      >
                        <option value="">Select timeline</option>
                        <option value="asap">ASAP</option>
                        <option value="1-month">Within 1 month</option>
                        <option value="2-3-months">2-3 months</option>
                        <option value="3-6-months">3-6 months</option>
                        <option value="flexible">Flexible</option>
                      </select>
                    </div>
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-1">Lighting Needs *</label>
                    <select
                      name="lightingNeeds"
                      value={formData.lightingNeeds}
                      onChange={handleChange}
                      required
                      className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                    >
                      <option value="">Select primary lighting need</option>
                      <option value="general-illumination">General Illumination</option>
                      <option value="task-lighting">Task Lighting</option>
                      <option value="accent-lighting">Accent Lighting</option>
                      <option value="mood-lighting">Mood/Ambiance Lighting</option>
                      <option value="energy-efficiency">Energy Efficiency Upgrade</option>
                      <option value="smart-controls">Smart Lighting Controls</option>
                      <option value="complete-redesign">Complete Lighting Redesign</option>
                    </select>
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-1">Additional Details</label>
                    <textarea
                      name="message"
                      value={formData.message}
                      onChange={handleChange}
                      rows={3}
                      className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent resize-none"
                      placeholder="Tell us about your specific lighting challenges, preferences, or any special requirements..."
                    />
                  </div>

                  <button
                    type="submit"
                    className="w-full px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 text-white font-semibold rounded-lg hover:from-yellow-600 hover:to-orange-600 transition-all duration-300 flex items-center justify-center gap-2 shadow-lg hover:shadow-xl"
                  >
                    <Send className="w-5 h-5" />
                    Consult Now - Request Lighting Consultation
                  </button>
                </form>
              )}
            </div>
          </div>
        </motion.div>
      </div>
        </div>
      </div>
    </div>
  );
};

export default LightingDesign;