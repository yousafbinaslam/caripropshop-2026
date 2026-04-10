import React from 'react';
import { motion } from 'framer-motion';
import { Leaf, Recycle, Zap, Droplets, Wind, TreePine, Award, CheckCircle } from 'lucide-react';

const EnvironmentalCompliance: React.FC = () => {
  return (
    <div className="min-h-screen bg-gray-50 py-20">
      <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          className="bg-white rounded-2xl shadow-lg p-8"
        >
          <div className="text-center mb-12">
            <Leaf className="w-16 h-16 text-green-500 mx-auto mb-4" />
            <h1 className="text-4xl font-bold text-gray-900 mb-4">Environmental Compliance</h1>
            <p className="text-gray-600">Sustainable design practices and environmental responsibility</p>
          </div>

          <div className="space-y-8">
            <section>
              <div className="flex items-center mb-4">
                <TreePine className="w-6 h-6 text-green-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Sustainable Design Framework</h2>
              </div>
              <div className="bg-green-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">Environmental Design Principles</h3>
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Resource Conservation</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Sustainable material selection</li>
                      <li>• Waste reduction strategies</li>
                      <li>• Water conservation systems</li>
                      <li>• Energy-efficient design solutions</li>
                      <li>• Renewable resource utilization</li>
                      <li>• Lifecycle assessment integration</li>
                    </ul>
                  </div>
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Environmental Impact Reduction</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Carbon footprint minimization</li>
                      <li>• Indoor air quality optimization</li>
                      <li>• Natural lighting maximization</li>
                      <li>• Toxic material elimination</li>
                      <li>• Biodegradable product preference</li>
                      <li>• Local sourcing prioritization</li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Award className="w-6 h-6 text-green-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Green Building Certifications</h2>
              </div>
              <div className="grid md:grid-cols-3 gap-6">
                <div className="bg-blue-50 p-6 rounded-lg border border-blue-200">
                  <h3 className="font-semibold text-gray-900 mb-3">LEED Certification</h3>
                  <div className="space-y-2 text-gray-700 text-sm">
                    <p><strong>Certification Level:</strong> LEED AP BD+C</p>
                    <p><strong>Specialization:</strong> Building Design + Construction</p>
                    <p><strong>Certified Professional:</strong> Adista Paramita</p>
                  </div>
                  <div className="mt-4">
                    <h4 className="font-medium text-gray-900 mb-2">LEED Categories:</h4>
                    <ul className="space-y-1 text-gray-700 text-xs">
                      <li>• Sustainable Sites</li>
                      <li>• Water Efficiency</li>
                      <li>• Energy & Atmosphere</li>
                      <li>• Materials & Resources</li>
                      <li>• Indoor Environmental Quality</li>
                    </ul>
                  </div>
                </div>
                <div className="bg-green-50 p-6 rounded-lg border border-green-200">
                  <h3 className="font-semibold text-gray-900 mb-3">Green Building Council Indonesia</h3>
                  <div className="space-y-2 text-gray-700 text-sm">
                    <p><strong>Certification:</strong> GBCI Accredited Professional</p>
                    <p><strong>Rating System:</strong> Greenship</p>
                    <p><strong>Focus Areas:</strong> Tropical Climate Design</p>
                  </div>
                  <div className="mt-4">
                    <h4 className="font-medium text-gray-900 mb-2">Greenship Criteria:</h4>
                    <ul className="space-y-1 text-gray-700 text-xs">
                      <li>• Appropriate Site Development</li>
                      <li>• Energy Efficiency & Conservation</li>
                      <li>• Water Conservation</li>
                      <li>• Material Resources & Cycle</li>
                      <li>• Indoor Health & Comfort</li>
                    </ul>
                  </div>
                </div>
                <div className="bg-purple-50 p-6 rounded-lg border border-purple-200">
                  <h3 className="font-semibold text-gray-900 mb-3">BREEAM International</h3>
                  <div className="space-y-2 text-gray-700 text-sm">
                    <p><strong>Assessment Method:</strong> BREEAM In-Use</p>
                    <p><strong>Scope:</strong> Existing Buildings</p>
                    <p><strong>Rating:</strong> Very Good to Outstanding</p>
                  </div>
                  <div className="mt-4">
                    <h4 className="font-medium text-gray-900 mb-2">Assessment Areas:</h4>
                    <ul className="space-y-1 text-gray-700 text-xs">
                      <li>• Management</li>
                      <li>• Health & Wellbeing</li>
                      <li>• Energy</li>
                      <li>• Transport</li>
                      <li>• Water & Waste</li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Zap className="w-6 h-6 text-green-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Energy Efficiency & Carbon Reduction</h2>
              </div>
              <div className="bg-gradient-to-r from-yellow-50 to-orange-50 p-6 rounded-lg">
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Energy Conservation Strategies</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li className="flex items-center">
                        <Zap className="w-4 h-4 text-yellow-600 mr-2" />
                        LED lighting systems (80% energy reduction)
                      </li>
                      <li className="flex items-center">
                        <Zap className="w-4 h-4 text-yellow-600 mr-2" />
                        Smart HVAC controls and zoning
                      </li>
                      <li className="flex items-center">
                        <Zap className="w-4 h-4 text-yellow-600 mr-2" />
                        High-performance insulation materials
                      </li>
                      <li className="flex items-center">
                        <Zap className="w-4 h-4 text-yellow-600 mr-2" />
                        Energy-efficient appliance specifications
                      </li>
                      <li className="flex items-center">
                        <Zap className="w-4 h-4 text-yellow-600 mr-2" />
                        Natural ventilation optimization
                      </li>
                    </ul>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Renewable Energy Integration</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li className="flex items-center">
                        <TreePine className="w-4 h-4 text-green-600 mr-2" />
                        Solar panel system design
                      </li>
                      <li className="flex items-center">
                        <TreePine className="w-4 h-4 text-green-600 mr-2" />
                        Geothermal heating/cooling systems
                      </li>
                      <li className="flex items-center">
                        <TreePine className="w-4 h-4 text-green-600 mr-2" />
                        Wind energy micro-turbines
                      </li>
                      <li className="flex items-center">
                        <TreePine className="w-4 h-4 text-green-600 mr-2" />
                        Energy storage solutions
                      </li>
                      <li className="flex items-center">
                        <TreePine className="w-4 h-4 text-green-600 mr-2" />
                        Grid-tie and net metering systems
                      </li>
                    </ul>
                  </div>
                </div>
                <div className="mt-6 p-4 bg-orange-100 rounded-lg">
                  <h4 className="font-semibold text-gray-900 mb-2">Carbon Footprint Reduction Targets</h4>
                  <div className="grid grid-cols-3 gap-4 text-center">
                    <div>
                      <p className="text-2xl font-bold text-orange-600">40%</p>
                      <p className="text-xs text-gray-700">Energy Use Reduction</p>
                    </div>
                    <div>
                      <p className="text-2xl font-bold text-green-600">60%</p>
                      <p className="text-xs text-gray-700">Carbon Emissions Cut</p>
                    </div>
                    <div>
                      <p className="text-2xl font-bold text-blue-600">30%</p>
                      <p className="text-xs text-gray-700">Water Usage Decrease</p>
                    </div>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Droplets className="w-6 h-6 text-green-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Water Conservation & Management</h2>
              </div>
              <div className="bg-blue-50 p-6 rounded-lg">
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Water Efficiency Measures</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li className="flex items-center">
                        <Droplets className="w-4 h-4 text-blue-600 mr-2" />
                        Low-flow fixtures and faucets
                      </li>
                      <li className="flex items-center">
                        <Droplets className="w-4 h-4 text-blue-600 mr-2" />
                        Dual-flush toilet systems
                      </li>
                      <li className="flex items-center">
                        <Droplets className="w-4 h-4 text-blue-600 mr-2" />
                        Greywater recycling systems
                      </li>
                      <li className="flex items-center">
                        <Droplets className="w-4 h-4 text-blue-600 mr-2" />
                        Rainwater harvesting integration
                      </li>
                      <li className="flex items-center">
                        <Droplets className="w-4 h-4 text-blue-600 mr-2" />
                        Smart irrigation controls
                      </li>
                    </ul>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Water Quality & Treatment</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-green-600 mr-2" />
                        Advanced filtration systems
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-green-600 mr-2" />
                        UV sterilization technology
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-green-600 mr-2" />
                        Water quality monitoring
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-green-600 mr-2" />
                        Leak detection systems
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-green-600 mr-2" />
                        Wastewater treatment solutions
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Recycle className="w-6 h-6 text-green-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Sustainable Materials & Waste Management</h2>
              </div>
              <div className="space-y-4">
                <div className="bg-green-50 p-6 rounded-lg">
                  <h3 className="font-semibold text-gray-900 mb-3">Sustainable Material Selection</h3>
                  <div className="grid md:grid-cols-3 gap-4">
                    <div>
                      <h4 className="font-medium text-gray-900 mb-2">Recycled Content</h4>
                      <ul className="space-y-1 text-gray-700 text-xs">
                        <li>• Recycled steel and aluminum</li>
                        <li>• Reclaimed wood products</li>
                        <li>• Recycled glass tiles</li>
                        <li>• Post-consumer plastic materials</li>
                        <li>• Recycled content carpeting</li>
                      </ul>
                    </div>
                    <div>
                      <h4 className="font-medium text-gray-900 mb-2">Rapidly Renewable</h4>
                      <ul className="space-y-1 text-gray-700 text-xs">
                        <li>• Bamboo flooring and panels</li>
                        <li>• Cork flooring materials</li>
                        <li>• Linoleum from natural sources</li>
                        <li>• Wool carpeting and textiles</li>
                        <li>• Natural rubber products</li>
                      </ul>
                    </div>
                    <div>
                      <h4 className="font-medium text-gray-900 mb-2">Local & Regional</h4>
                      <ul className="space-y-1 text-gray-700 text-xs">
                        <li>• Indonesian teak and hardwoods</li>
                        <li>• Local stone and ceramics</li>
                        <li>• Regional textile products</li>
                        <li>• Locally manufactured furniture</li>
                        <li>• Regional metal fabrication</li>
                      </ul>
                    </div>
                  </div>
                </div>

                <div className="bg-purple-50 p-6 rounded-lg">
                  <h3 className="font-semibold text-gray-900 mb-3">Waste Reduction & Management</h3>
                  <div className="grid md:grid-cols-2 gap-6">
                    <div>
                      <h4 className="font-medium text-gray-900 mb-2">Construction Waste Diversion</h4>
                      <ul className="space-y-1 text-gray-700 text-sm">
                        <li>• 75% waste diversion target</li>
                        <li>• Material salvage and reuse</li>
                        <li>• On-site recycling programs</li>
                        <li>• Donation of usable materials</li>
                        <li>• Composting organic waste</li>
                      </ul>
                    </div>
                    <div>
                      <h4 className="font-medium text-gray-900 mb-2">Operational Waste Management</h4>
                      <ul className="space-y-1 text-gray-700 text-sm">
                        <li>• Comprehensive recycling systems</li>
                        <li>• Organic waste composting</li>
                        <li>• Hazardous material disposal</li>
                        <li>• E-waste recycling programs</li>
                        <li>• Zero-waste-to-landfill goals</li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Wind className="w-6 h-6 text-green-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Indoor Environmental Quality</h2>
              </div>
              <div className="bg-indigo-50 p-6 rounded-lg">
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Air Quality Management</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li className="flex items-center">
                        <Wind className="w-4 h-4 text-indigo-600 mr-2" />
                        Low-VOC paints and finishes
                      </li>
                      <li className="flex items-center">
                        <Wind className="w-4 h-4 text-indigo-600 mr-2" />
                        Formaldehyde-free materials
                      </li>
                      <li className="flex items-center">
                        <Wind className="w-4 h-4 text-indigo-600 mr-2" />
                        Advanced air filtration systems
                      </li>
                      <li className="flex items-center">
                        <Wind className="w-4 h-4 text-indigo-600 mr-2" />
                        Natural ventilation strategies
                      </li>
                      <li className="flex items-center">
                        <Wind className="w-4 h-4 text-indigo-600 mr-2" />
                        Indoor plant integration
                      </li>
                    </ul>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Comfort & Wellness</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-green-600 mr-2" />
                        Optimal temperature and humidity control
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-green-600 mr-2" />
                        Natural daylight optimization
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-green-600 mr-2" />
                        Acoustic comfort design
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-green-600 mr-2" />
                        Ergonomic workspace design
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-green-600 mr-2" />
                        Biophilic design elements
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <CheckCircle className="w-6 h-6 text-green-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Environmental Monitoring & Reporting</h2>
              </div>
              <div className="bg-yellow-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">Performance Tracking</h3>
                <div className="grid md:grid-cols-3 gap-4">
                  <div className="bg-white p-4 rounded border text-center">
                    <Zap className="w-8 h-8 text-yellow-600 mx-auto mb-2" />
                    <h4 className="font-semibold text-gray-900 mb-2">Energy Monitoring</h4>
                    <p className="text-gray-700 text-sm">Real-time energy consumption tracking</p>
                  </div>
                  <div className="bg-white p-4 rounded border text-center">
                    <Droplets className="w-8 h-8 text-blue-600 mx-auto mb-2" />
                    <h4 className="font-semibold text-gray-900 mb-2">Water Usage</h4>
                    <p className="text-gray-700 text-sm">Continuous water consumption monitoring</p>
                  </div>
                  <div className="bg-white p-4 rounded border text-center">
                    <Wind className="w-8 h-8 text-green-600 mx-auto mb-2" />
                    <h4 className="font-semibold text-gray-900 mb-2">Air Quality</h4>
                    <p className="text-gray-700 text-sm">Indoor environmental quality assessment</p>
                  </div>
                </div>
                <div className="mt-6 p-4 bg-yellow-100 rounded-lg">
                  <h4 className="font-semibold text-gray-900 mb-2">Annual Sustainability Report</h4>
                  <p className="text-gray-700 text-sm">
                    Comprehensive annual reporting on environmental performance, including energy savings, 
                    water conservation, waste diversion rates, and carbon footprint reduction achievements.
                  </p>
                </div>
              </div>
            </section>

            <section className="border-t pt-8">
              <h2 className="text-2xl font-semibold text-gray-900 mb-4">Environmental Compliance Contact</h2>
              <div className="bg-green-50 p-6 rounded-lg">
                <p className="text-gray-700 mb-4">
                  For environmental compliance questions, sustainability consulting, or green building certification assistance.
                </p>
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-2">Sustainability Director</h3>
                    <div className="space-y-1 text-gray-700 text-sm">
                      <p><strong>Name:</strong> Cari Prop Shop</p>
                      <p><strong>Email:</strong> sustainability@caripropshop.com</p>
                      <p><strong>Phone:</strong> Available upon request</p>
                      <p><strong>Certification:</strong> LEED AP BD+C</p>
                    </div>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-2">Services Available</h3>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Green building certification consulting</li>
                      <li>• Environmental impact assessments</li>
                      <li>• Sustainability strategy development</li>
                      <li>• LEED and GBCI project registration</li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </motion.div>
      </div>
    </div>
  );
};

export default EnvironmentalCompliance;