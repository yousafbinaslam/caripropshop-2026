import React, { useState } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { Ruler, Layout, Grid, Maximize, CheckCircle, Send, Phone, Mail, ArrowLeft, Star, Award, Target, Users } from 'lucide-react';
import { sendAutomatedResponse } from '../utils/emailService';
import Header from './Header';

const SpacePlanning: React.FC = () => {
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    phone: '',
    projectType: '',
    spaceSize: '',
    currentLayout: '',
    challenges: '',
    goals: '',
    timeline: '',
    location: '',
    budget: '',
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
      formType: 'Space Planning Consultation',
      projectType: formData.projectType,
      spaceSize: formData.spaceSize,
      currentLayout: formData.currentLayout,
      challenges: formData.challenges,
      goals: formData.goals,
      timeline: formData.timeline,
      location: formData.location,
      budget: formData.budget,
      message: formData.message
    });
    
    setIsSubmitted(true);
    setTimeout(() => setIsSubmitted(false), 3000);
    setFormData({
      name: '',
      email: '',
      phone: '',
      projectType: '',
      spaceSize: '',
      currentLayout: '',
      challenges: '',
      goals: '',
      timeline: '',
      location: '',
      budget: '',
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
            <div className="w-20 h-20 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
              <Ruler className="w-10 h-10 text-white" />
            </div>
          </div>
          <h1 className="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
            Professional Space Planning
          </h1>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Optimize your space layout for maximum functionality and flow. Our expert space planners 
            create efficient, beautiful layouts that make the most of every square meter.
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
              icon: Layout,
              title: 'Floor Plan Design',
              description: 'Detailed floor plans optimized for functionality and flow',
              features: ['CAD drawings', 'Furniture layouts', 'Traffic flow analysis', 'Dimension specifications']
            },
            {
              icon: Grid,
              title: '3D Space Visualization',
              description: 'See your space come to life with realistic 3D renderings',
              features: ['3D modeling', 'Virtual walkthroughs', 'Multiple angles', 'Material visualization']
            },
            {
              icon: Maximize,
              title: 'Space Optimization',
              description: 'Maximize every inch of your space with smart planning',
              features: ['Storage solutions', 'Multi-functional areas', 'Space efficiency', 'Ergonomic design']
            }
          ].map((service, index) => (
            <motion.div
              key={index}
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6, delay: 0.3 + index * 0.1 }}
              className="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow"
            >
              <service.icon className="w-12 h-12 text-indigo-500 mb-6" />
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

        {/* Process & Benefits */}
        <div className="grid lg:grid-cols-2 gap-12 mb-16">
          <motion.div
            initial={{ opacity: 0, x: -20 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.8, delay: 0.5 }}
            className="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-8"
          >
            <h2 className="text-2xl font-bold text-gray-900 mb-6">Our Planning Process</h2>
            <div className="space-y-6">
              {[
                { step: '1', title: 'Site Analysis', desc: 'Detailed measurement and assessment of your space' },
                { step: '2', title: 'Needs Assessment', desc: 'Understanding your lifestyle and functional requirements' },
                { step: '3', title: 'Concept Development', desc: 'Creating multiple layout options for your review' },
                { step: '4', title: 'Design Refinement', desc: 'Perfecting the chosen layout with detailed specifications' },
                { step: '5', title: 'Final Documentation', desc: 'Complete drawings and implementation guidelines' }
              ].map((phase, index) => (
                <div key={index} className="flex items-start">
                  <div className="w-8 h-8 bg-indigo-500 text-white rounded-full flex items-center justify-center font-bold text-sm mr-4 mt-1">
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
            <h2 className="text-2xl font-bold text-gray-900 mb-6">Why Choose Our Space Planning?</h2>
            <div className="space-y-4">
              {[
                { benefit: 'Maximize space efficiency by up to 30%', icon: Target },
                { benefit: 'Improve traffic flow and functionality', icon: Users },
                { benefit: 'Professional CAD drawings included', icon: Ruler },
                { benefit: '3D visualizations for better understanding', icon: Layout },
                { benefit: 'Compliance with building codes', icon: CheckCircle },
                { benefit: 'Future-proof flexible designs', icon: Star }
              ].map((item, index) => (
                <div key={index} className="flex items-center">
                  <item.icon className="w-5 h-5 text-indigo-500 mr-3" />
                  <span className="text-gray-700">{item.benefit}</span>
                </div>
              ))}
            </div>

            <div className="mt-8 p-4 bg-indigo-50 rounded-lg">
              <h3 className="font-semibold text-gray-900 mb-2">📐 Professional Space Planning</h3>
              <p className="text-gray-600 text-sm">
                Our space planning services are customized to your specific needs and space requirements. 
                Contact us for detailed consultation and pricing.
              </p>
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
              <h2 className="text-3xl font-bold text-gray-900 mb-6">Get Professional Space Planning</h2>
              <p className="text-gray-600 mb-8">
                Ready to optimize your space? Contact our space planning specialists for a 
                consultation and custom layout design tailored to your needs.
              </p>
              
              <div className="space-y-4 mb-8">
                <div className="flex items-center">
                  <Phone className="w-5 h-5 text-indigo-500 mr-3" />
                  <div>
                    <p className="font-medium text-gray-900">Space Planning Team</p>
                    <p className="text-gray-600">+6282233039914</p>
                  </div>
                </div>
                <div className="flex items-center">
                  <Mail className="w-5 h-5 text-indigo-500 mr-3" />
                  <div>
                    <p className="font-medium text-gray-900">Planning Specialists</p>
                    <p className="text-gray-600">planning@caripropshop.com</p>
                  </div>
                </div>
              </div>

              <div className="grid grid-cols-3 gap-4 text-center">
                <div className="p-4 bg-indigo-50 rounded-lg">
                  <Ruler className="w-6 h-6 text-indigo-500 mx-auto mb-2" />
                  <p className="text-sm font-medium text-gray-900">200+</p>
                  <p className="text-xs text-gray-600">Spaces Planned</p>
                </div>
                <div className="p-4 bg-indigo-50 rounded-lg">
                  <Award className="w-6 h-6 text-indigo-500 mx-auto mb-2" />
                  <p className="text-sm font-medium text-gray-900">95%</p>
                  <p className="text-xs text-gray-600">Efficiency Gain</p>
                </div>
                <div className="p-4 bg-indigo-50 rounded-lg">
                  <Target className="w-6 h-6 text-indigo-500 mx-auto mb-2" />
                  <p className="text-sm font-medium text-gray-900">100%</p>
                  <p className="text-xs text-gray-600">Custom Solutions</p>
                </div>
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
                    Our space planning team will contact you within 24 hours to discuss your project.
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
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
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
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
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
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="+62 xxx xxx xxxx"
                      />
                    </div>
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Location</label>
                      <input
                        type="text"
                        name="location"
                        value={formData.location}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="City, Indonesia"
                      />
                    </div>
                  </div>

                  <div className="grid md:grid-cols-2 gap-4">
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Project Type *</label>
                      <select
                        name="projectType"
                        value={formData.projectType}
                        onChange={handleChange}
                        required
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                      >
                        <option value="">Select project type</option>
                        <option value="residential">Residential</option>
                        <option value="commercial">Commercial</option>
                        <option value="office">Office</option>
                        <option value="retail">Retail</option>
                        <option value="hospitality">Hospitality</option>
                        <option value="mixed-use">Mixed Use</option>
                      </select>
                    </div>
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Space Size</label>
                      <input
                        type="text"
                        name="spaceSize"
                        value={formData.spaceSize}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="e.g., 150 sqm"
                      />
                    </div>
                  </div>

                  <div className="grid md:grid-cols-2 gap-4">
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Current Layout</label>
                      <select
                        name="currentLayout"
                        value={formData.currentLayout}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                      >
                        <option value="">Select current state</option>
                        <option value="empty-space">Empty Space</option>
                        <option value="existing-layout">Existing Layout</option>
                        <option value="needs-renovation">Needs Renovation</option>
                        <option value="partial-renovation">Partial Renovation</option>
                        <option value="new-construction">New Construction</option>
                      </select>
                    </div>
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Timeline</label>
                      <select
                        name="timeline"
                        value={formData.timeline}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
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

                  <div className="grid md:grid-cols-2 gap-4">
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Main Challenges</label>
                      <select
                        name="challenges"
                        value={formData.challenges}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                      >
                        <option value="">Select main challenge</option>
                        <option value="limited-space">Limited Space</option>
                        <option value="poor-flow">Poor Traffic Flow</option>
                        <option value="lack-storage">Lack of Storage</option>
                        <option value="awkward-layout">Awkward Layout</option>
                        <option value="multi-functional">Multi-functional Needs</option>
                        <option value="structural-constraints">Structural Constraints</option>
                      </select>
                    </div>
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Primary Goals</label>
                      <select
                        name="goals"
                        value={formData.goals}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                      >
                        <option value="">Select primary goal</option>
                        <option value="maximize-space">Maximize Space</option>
                        <option value="improve-flow">Improve Flow</option>
                        <option value="increase-storage">Increase Storage</option>
                        <option value="better-functionality">Better Functionality</option>
                        <option value="open-concept">Open Concept</option>
                        <option value="privacy-zones">Privacy Zones</option>
                      </select>
                    </div>
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-1">Budget Range</label>
                    <select
                      name="budget"
                      value={formData.budget}
                      onChange={handleChange}
                      className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    >
                      <option value="">Select budget range</option>
                      <option value="under-5k">Under $5,000</option>
                      <option value="5k-15k">$5,000 - $15,000</option>
                      <option value="15k-30k">$15,000 - $30,000</option>
                      <option value="30k-50k">$30,000 - $50,000</option>
                      <option value="over-50k">Over $50,000</option>
                    </select>
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-1">Project Details</label>
                    <textarea
                      name="message"
                      value={formData.message}
                      onChange={handleChange}
                      rows={4}
                      className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none"
                      placeholder="Tell us about your space planning needs, specific requirements, or any other details that would help us understand your project..."
                    />
                  </div>

                  <button
                    type="submit"
                    className="w-full px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold rounded-lg hover:from-indigo-600 hover:to-purple-700 transition-all duration-300 flex items-center justify-center gap-2 shadow-lg hover:shadow-xl"
                  >
                    <Send className="w-5 h-5" />
                    Request Space Planning Consultation
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

export default SpacePlanning;