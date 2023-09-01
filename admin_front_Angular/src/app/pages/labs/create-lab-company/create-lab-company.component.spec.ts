import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CreateLabCompanyComponent } from './create-lab-company.component';

describe('CreateLabCompanyComponent', () => {
  let component: CreateLabCompanyComponent;
  let fixture: ComponentFixture<CreateLabCompanyComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [CreateLabCompanyComponent]
    });
    fixture = TestBed.createComponent(CreateLabCompanyComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
