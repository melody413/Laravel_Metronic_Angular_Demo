import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CreatePharmacyComponent } from './create-pharmacy.component';

describe('CreatePharmacyComponent', () => {
  let component: CreatePharmacyComponent;
  let fixture: ComponentFixture<CreatePharmacyComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [CreatePharmacyComponent]
    });
    fixture = TestBed.createComponent(CreatePharmacyComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
